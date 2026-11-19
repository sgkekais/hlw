<?php

namespace Tests\Feature;

use Carbon\Carbon;
use HLW\Club;
use HLW\Player;
use HLW\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\Concerns\UsesRealRecords;
use Tests\TestCase;

/**
 * Passport folder (Passmappe) and single passports in the admin area, see HLW\Support\PlayerPassports.
 */
class PlayerPassportsTest extends TestCase
{
    use DatabaseTransactions, UsesRealRecords;

    private Club $club;
    private $players;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        Storage::fake('local');

        // a club with a few active players, so rendering stays quick
        $this->club = Club::whereHas('players', fn ($q) => $q->whereNull('sign_off'), '>=', 3)->firstOrFail();
        $this->players = $this->club->players()->whereNull('sign_off')->get();

        // one photo shared by two players, one player without photo, a logo with transparency
        Storage::disk('public')->put('passportphotos/1/a.jpg', $this->image(480, 640, 'jpeg'));
        Storage::disk('public')->put('passportphotos/2/b.jpg', $this->image(480, 640, 'jpeg'));
        Storage::disk('public')->put('clublogos/1/logo.png', $this->image(200, 200, 'png'));
        $personIds = $this->players->pluck('person_id');
        DB::table('people')->whereIn('id', $personIds)->update(['photo' => 'passportphotos/1/a.jpg']);
        DB::table('people')->where('id', $personIds[0])->update(['photo' => 'passportphotos/2/b.jpg']);
        DB::table('people')->where('id', $personIds[1])->update(['photo' => null]);
        DB::table('clubs')->where('id', $this->club->id)->update(['logo_url' => 'clublogos/1/logo.png', 'passports_url' => null]);
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_passport_folder_is_stored_privately_and_replaces_the_previous_one()
    {
        $this->actingAs(User::role('admin')->firstOrFail());

        Carbon::setTestNow('2026-11-19 10:00:00');
        $this->post(route('generatePlayerPassports', $this->club))->assertRedirect(route('clubs.show', $this->club));
        $first = $this->club->fresh()->passports_url;
        $this->assertSame('clubpassports/'.$this->club->id.'/2026-11-19_100000_Passmappe.pdf', $first);
        Storage::disk('local')->assertExists($first);
        $this->assertEmpty(Storage::disk('public')->allFiles('clubpassports'));

        $pdf = Storage::disk('local')->get($first);
        // one page per active player, no empty page at the end
        $this->assertSame($this->players->count(), preg_match_all('#/Type\s*/Page\b#', $pdf));
        // background, logo (+ its alpha mask) and the two photos are embedded once each
        $this->assertLessThanOrEqual(5, preg_match_all('#/Subtype\s*/Image#', $pdf));

        Carbon::setTestNow('2026-11-19 11:30:00');
        $this->post(route('generatePlayerPassports', $this->club));
        $second = $this->club->fresh()->passports_url;
        $this->assertNotSame($first, $second);
        Storage::disk('local')->assertMissing($first);
        Storage::disk('local')->assertExists($second);
        $this->assertSame('2026-11-19 11:30:00', Carbon::parse($this->club->fresh()->passports_timestamp)->format('Y-m-d H:i:s'));

        // the club page shows the links with the date
        $this->get(route('clubs.show', $this->club))
            ->assertSee(route('displayPlayerPassports', $this->club))
            ->assertSee('Stand: 19.11.2026 11:30 Uhr');
    }

    public function test_download_only_for_admins()
    {
        Storage::disk('local')->put('clubpassports/x/mappe.pdf', '%PDF-1.7 test');
        DB::table('clubs')->where('id', $this->club->id)->update(['passports_url' => 'clubpassports/x/mappe.pdf', 'passports_timestamp' => '2026-11-19 10:00:00']);
        $url = route('displayPlayerPassports', $this->club);

        $this->get($url)->assertRedirect(route('login'));
        $this->actingAs($this->createMember())->get($url)->assertStatus(403);

        $response = $this->actingAs(User::role('admin')->firstOrFail())->get($url)->assertOk();
        $this->assertStringContainsString('2026-11-19_Passmappe_'.$this->club->name_code.'.pdf', $response->headers->get('Content-Disposition'));
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));

        Storage::disk('local')->delete('clubpassports/x/mappe.pdf');
        $this->get($url)->assertNotFound();
    }

    public function test_single_passport()
    {
        $this->actingAs(User::role('admin')->firstOrFail());
        $player = $this->players->first();

        $response = $this->get(route('generatePlayerPassport', [$this->club, $player]))->assertOk();
        $this->assertSame('application/pdf', $response->headers->get('Content-Type'));
        $this->assertStringStartsWith('inline;', $response->headers->get('Content-Disposition'));
        $this->assertSame(1, preg_match_all('#/Type\s*/Page\b#', $response->getContent()));
        $this->assertEmpty(Storage::disk('local')->allFiles());

        // a player of another club is not found under this club
        $other = Player::where('club_id', '!=', $this->club->id)->firstOrFail();
        $this->get(route('generatePlayerPassport', [$this->club, $other]))->assertNotFound();
    }

    private function image(int $width, int $height, string $format): string
    {
        $image = imagecreatetruecolor($width, $height);
        imagesavealpha($image, true);
        imagefill($image, 0, 0, imagecolorallocatealpha($image, 30, 120, 60, $format === 'png' ? 60 : 0));
        ob_start();
        $format === 'png' ? imagepng($image) : imagejpeg($image);

        return ob_get_clean();
    }
}
