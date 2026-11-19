<?php

namespace HLW\Console\Commands;

use HLW\Support\PassportPhoto;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Replaces the stored passport photos by optimized copies, see PassportPhoto.
 * Photos that are already optimized are skipped, so it can run more than once.
 *
 * Without --force it only reports what it would do.
 */
class OptimizePassportPhotos extends Command
{
    protected $signature = 'hlw:optimize-passport-photos {--force : replace the photos, otherwise only report}';

    protected $description = 'Replace the passport photos by optimized copies (JPEG, at most 640 px, without metadata)';

    public function handle(): int
    {
        $force = $this->option('force');
        $disk = Storage::disk('public');
        $this->info($force ? 'Replacing photos.' : 'Dry run, nothing is changed. Use --force to replace the photos.');

        $counts = ['optimized' => 0, 'already optimized' => 0, 'file missing' => 0, 'failed' => 0, 'smaller than 300 px' => 0];
        $bytesBefore = 0;
        $bytesAfter = 0;

        $people = DB::table('people')->whereNotNull('photo')->orderBy('id')->get(['id', 'photo']);

        foreach ($people as $person) {
            $stored = PassportPhoto::normalize($person->photo);
            if (!$disk->exists($stored)) {
                $counts['file missing']++;
                continue;
            }

            $source = $disk->path($stored);
            $info = @getimagesize($source);
            if ($info && min($info[0], $info[1]) < 300) {
                $counts['smaller than 300 px']++;
            }

            if ($this->isOptimized($person->photo, $source, $info)) {
                $counts['already optimized']++;
                continue;
            }

            try {
                $data = PassportPhoto::optimize($source);
            } catch (Throwable $e) {
                $counts['failed']++;
                $this->warn("person {$person->id}: ".$e->getMessage());
                continue;
            }

            $sizeBefore = filesize($source) ?: 0;

            if ($force) {
                // new file first, the original is only deleted once the record points to the copy
                try {
                    $path = PassportPhoto::store($data, $person->id);
                } catch (Throwable $e) {
                    $counts['failed']++;
                    $this->warn("person {$person->id}: ".$e->getMessage());
                    continue;
                }
                // without the model, so the activity log is not flooded
                DB::table('people')->where('id', $person->id)->update(['photo' => $path]);
                $disk->delete($stored);
            }

            $counts['optimized']++;
            $bytesBefore += $sizeBefore;
            $bytesAfter += strlen($data);
        }

        $this->table(['', 'Photos'], collect($counts)->map(fn ($count, $label) => [$label, $count])->values()->all());
        $this->line(sprintf('Size of the optimized photos: %.1f MB before, %.1f MB after', $bytesBefore / 1048576, $bytesAfter / 1048576));

        return self::SUCCESS;
    }

    /**
     * A JPEG within the size limit and without metadata counts as optimized, see PassportPhoto::store().
     */
    private function isOptimized(string $path, string $source, $info): bool
    {
        return $info
            && $info[2] === IMAGETYPE_JPEG
            && max($info[0], $info[1]) <= PassportPhoto::MAX_EDGE
            && str_ends_with($path, '.jpg')
            && !PassportPhoto::hasExif($source);
    }
}
