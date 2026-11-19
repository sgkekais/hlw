<?php

namespace HLW\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Removes uploads that are not needed anymore:
 * - match reports of past seasons (file and reference)
 * - files in the upload folders that no record refers to
 *
 * Without --force it only reports what it would delete.
 */
class CleanUploads extends Command
{
    protected $signature = 'hlw:clean-uploads {--force : delete, otherwise only report}';

    protected $description = 'Delete match reports of past seasons and upload files without a reference';

    /**
     * Upload folders and the columns that refer to their files.
     */
    const FOLDERS = [
        'passportphotos' => [['people', 'photo']],
        'clubpassports'  => [['clubs', 'passports_url']],
        'clublogos'      => [['clubs', 'logo_url']],
        'clubcovers'     => [['clubs', 'cover_url']],
        'matchreports'   => [['fixtures', 'match_report_url']],
    ];

    /**
     * Folders that are not on the public disk.
     */
    const DISKS = [
        'clubpassports' => 'local',
    ];

    public function handle(): int
    {
        $force = $this->option('force');
        $this->info($force ? 'Deleting.' : 'Dry run, nothing is deleted. Use --force to delete.');

        // match reports of seasons that ended before today
        $pastReports = DB::table('fixtures')
            ->join('matchweeks', 'matchweeks.id', '=', 'fixtures.matchweek_id')
            ->join('seasons', 'seasons.id', '=', 'matchweeks.season_id')
            ->whereNotNull('fixtures.match_report_url')
            ->whereDate('seasons.end', '<', Carbon::today())
            ->pluck('fixtures.match_report_url', 'fixtures.id');

        // references before anything is deleted, for the safety net below
        $hadReferences = collect(self::FOLDERS)->map(fn ($columns) => $this->references($columns)->isNotEmpty());

        $this->line(sprintf('Match reports of past seasons: %d', $pastReports->count()));
        if ($force && $pastReports->isNotEmpty()) {
            Storage::disk('public')->delete($pastReports->values()->all());
            // without the models, so the activity log is not flooded
            DB::table('fixtures')->whereIn('id', $pastReports->keys())->update(['match_report_url' => null]);
        }

        $rows = [];
        foreach (self::FOLDERS as $folder => $columns) {
            $disk = Storage::disk(self::DISKS[$folder] ?? 'public');
            $referenced = $this->references($columns);
            // in a dry run the past match reports still count as referenced in the database
            if (!$force && $folder === 'matchreports') {
                $referenced = $referenced->diff($pastReports->values());
            }
            $referenced = $referenced->map(fn ($path) => ltrim(preg_replace('#^public/#', '', $path), '/'))->flip();

            $files = collect($disk->allFiles($folder));
            $orphans = $files->reject(fn ($file) => $referenced->has($file));
            $size = $orphans->sum(fn ($file) => $disk->size($file));

            // safety net: never empty a whole folder because the references could not be read
            $skipped = $files->isNotEmpty() && !$hadReferences[$folder];
            if ($force && !$skipped && $orphans->isNotEmpty()) {
                $disk->delete($orphans->all());
                foreach (array_reverse($disk->allDirectories($folder)) as $directory) {
                    if (empty($disk->allFiles($directory))) {
                        $disk->deleteDirectory($directory);
                    }
                }
            }

            $rows[] = [
                $folder,
                $files->count(),
                $referenced->count(),
                $orphans->count(),
                round($size / 1048576, 1).' MB',
                $skipped ? 'skipped, no references' : ($force ? 'deleted' : 'would delete'),
            ];
        }

        $this->table(['Folder', 'Files', 'References', 'Without reference', 'Size', 'Action'], $rows);

        return self::SUCCESS;
    }

    private function references(array $columns)
    {
        return collect($columns)->flatMap(function ($column) {
            [$table, $field] = $column;

            return DB::table($table)->whereNotNull($field)->pluck($field);
        });
    }
}
