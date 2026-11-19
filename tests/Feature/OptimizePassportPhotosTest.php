<?php

namespace Tests\Feature;

use HLW\Person;
use HLW\Support\PassportPhoto;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OptimizePassportPhotosTest extends TestCase
{
    use DatabaseTransactions;

    private $people;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        DB::table('people')->update(['photo' => null]);
        $this->people = Person::orderBy('id')->limit(4)->get();

        $disk = Storage::disk('public');
        // a large PNG, an already optimized JPEG, an old path with the prefix public/, a missing file
        $disk->put('passportphotos/1/large.png', $this->image(1500, 2000, 'png'));
        $disk->put('passportphotos/2/'.str_repeat('a', 40).'.jpg', $this->image(480, 640, 'jpeg'));
        $disk->put('passportphotos/3/old.jpeg', $this->image(900, 1200, 'jpeg'));
        $paths = ['passportphotos/1/large.png', 'passportphotos/2/'.str_repeat('a', 40).'.jpg', 'public/passportphotos/3/old.jpeg', 'passportphotos/4/missing.jpg'];
        foreach ($this->people as $i => $person) {
            DB::table('people')->where('id', $person->id)->update(['photo' => $paths[$i]]);
        }
    }

    public function test_dry_run_changes_nothing()
    {
        $this->artisan('hlw:optimize-passport-photos')
            ->expectsTable(['', 'Photos'], [
                ['optimized', 2], ['already optimized', 1], ['file missing', 1], ['failed', 0], ['smaller than 300 px', 0],
            ])
            ->assertSuccessful();

        $this->assertSame('passportphotos/1/large.png', $this->people[0]->fresh()->photo);
        Storage::disk('public')->assertExists(['passportphotos/1/large.png', 'passportphotos/3/old.jpeg']);
    }

    public function test_force_replaces_files_and_records_and_a_second_run_does_nothing()
    {
        $this->artisan('hlw:optimize-passport-photos', ['--force' => true])->assertSuccessful();

        $disk = Storage::disk('public');
        $disk->assertMissing(['passportphotos/1/large.png', 'passportphotos/3/old.jpeg']);
        foreach ([0 => [480, 640], 2 => [480, 640]] as $i => $size) {
            $photo = $this->people[$i]->fresh()->photo;
            $this->assertMatchesRegularExpression('#^passportphotos/'.$this->people[$i]->id.'/\w{40}\.jpg$#', $photo);
            $this->assertSame([...$size, IMAGETYPE_JPEG], array_slice(getimagesize($disk->path($photo)), 0, 3));
        }
        // already optimized and missing files stay as they are
        $this->assertSame('passportphotos/2/'.str_repeat('a', 40).'.jpg', $this->people[1]->fresh()->photo);
        $this->assertSame('passportphotos/4/missing.jpg', $this->people[3]->fresh()->photo);

        $this->artisan('hlw:optimize-passport-photos', ['--force' => true])
            ->expectsTable(['', 'Photos'], [
                ['optimized', 0], ['already optimized', 3], ['file missing', 1], ['failed', 0], ['smaller than 300 px', 0],
            ]);
    }

    public function test_photos_with_exif_count_as_not_optimized()
    {
        $jpeg = $this->image(480, 640, 'jpeg');
        $exif = "Exif\0\0".'II*'."\0".pack('V', 8).pack('v', 0).pack('V', 0);
        Storage::disk('public')->put('passportphotos/2/'.str_repeat('a', 40).'.jpg', substr($jpeg, 0, 2)."\xFF\xE1".pack('n', strlen($exif) + 2).$exif.substr($jpeg, 2));

        $this->artisan('hlw:optimize-passport-photos', ['--force' => true])->assertSuccessful();

        $this->assertFalse(PassportPhoto::hasExif(Storage::disk('public')->path($this->people[1]->fresh()->photo)));
    }

    private function image(int $width, int $height, string $format): string
    {
        $image = imagecreatetruecolor($width, $height);
        ob_start();
        $format === 'png' ? imagepng($image) : imagejpeg($image);

        return ob_get_clean();
    }
}
