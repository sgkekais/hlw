<?php

namespace Tests\Feature;

use Carbon\Carbon;
use HLW\Fixture;
use HLW\Person;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CleanUploadsTest extends TestCase
{
    use DatabaseTransactions;

    private $pastFixture;
    private $currentFixture;
    private $person;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        // only the records of this test refer to files
        DB::table('fixtures')->update(['match_report_url' => null]);
        DB::table('people')->update(['photo' => null]);
        DB::table('clubs')->update(['logo_url' => null, 'cover_url' => null, 'passports_url' => null]);

        $this->pastFixture = Fixture::whereHas('matchweek.season', fn ($q) => $q->whereDate('end', '<', Carbon::today()))->firstOrFail();
        $this->currentFixture = Fixture::whereHas('matchweek.season', fn ($q) => $q->whereDate('end', '>=', Carbon::today()))->firstOrFail();
        $this->person = Person::firstOrFail();

        DB::table('fixtures')->where('id', $this->pastFixture->id)->update(['match_report_url' => 'matchreports/1/old.jpg']);
        DB::table('fixtures')->where('id', $this->currentFixture->id)->update(['match_report_url' => 'matchreports/2/current.jpg']);
        DB::table('people')->where('id', $this->person->id)->update(['photo' => 'passportphotos/1/kept.jpg']);

        foreach (['matchreports/1/old.jpg', 'matchreports/2/current.jpg', 'matchreports/3/orphan.jpg',
                  'passportphotos/1/kept.jpg', 'passportphotos/1/replaced.jpg', 'clublogos/1/orphan.png', 'spielberichtsbogen.pdf'] as $file) {
            Storage::disk('public')->put($file, 'x');
        }
    }

    public function test_dry_run_deletes_nothing()
    {
        $this->artisan('hlw:clean-uploads')->assertSuccessful();

        Storage::disk('public')->assertExists(['matchreports/1/old.jpg', 'matchreports/3/orphan.jpg', 'passportphotos/1/replaced.jpg']);
        $this->assertSame('matchreports/1/old.jpg', $this->pastFixture->fresh()->match_report_url);
    }

    public function test_force_deletes_past_reports_and_files_without_reference()
    {
        $this->artisan('hlw:clean-uploads', ['--force' => true])->assertSuccessful();

        $disk = Storage::disk('public');
        // match report of a past season: file and reference are gone
        $disk->assertMissing('matchreports/1/old.jpg');
        $this->assertNull($this->pastFixture->fresh()->match_report_url);
        // current season stays
        $disk->assertExists('matchreports/2/current.jpg');
        $this->assertSame('matchreports/2/current.jpg', $this->currentFixture->fresh()->match_report_url);
        // files without reference are gone, referenced ones and files outside the folders stay
        $disk->assertMissing(['matchreports/3/orphan.jpg', 'passportphotos/1/replaced.jpg']);
        $disk->assertExists(['passportphotos/1/kept.jpg', 'spielberichtsbogen.pdf']);
        $this->assertFalse($disk->exists('matchreports/3'));
    }

    public function test_a_folder_without_any_reference_is_not_emptied()
    {
        // no club has a logo: the folder is skipped instead of deleting every logo
        $this->artisan('hlw:clean-uploads', ['--force' => true])->assertSuccessful();

        Storage::disk('public')->assertExists('clublogos/1/orphan.png');
    }

    public function test_orphan_reports_are_deleted_when_only_past_reports_were_referenced()
    {
        DB::table('fixtures')->where('id', $this->currentFixture->id)->update(['match_report_url' => null]);

        $this->artisan('hlw:clean-uploads', ['--force' => true])->assertSuccessful();

        Storage::disk('public')->assertMissing(['matchreports/1/old.jpg', 'matchreports/3/orphan.jpg']);
    }
}
