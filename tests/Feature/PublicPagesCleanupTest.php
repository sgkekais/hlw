<?php

namespace Tests\Feature;

use HLW\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Concerns\UsesRealRecords;
use Tests\TestCase;

/**
 * Blocks that were only visible to logged in users are gone from the public pages,
 * the board on the info page is up to date.
 */
class PublicPagesCleanupTest extends TestCase
{
    use DatabaseTransactions, UsesRealRecords;

    public function test_info_page_shows_the_current_board_and_the_match_report_form()
    {
        $this->get('/infos')
            ->assertStatus(200)
            ->assertDontSee('Stefan Abels')
            ->assertDontSee('Ansprechpartner Teams')
            ->assertDontSee('id="referees"', false)
            ->assertSee(route('frontend.static.matchreport'), false);
    }

    public function test_contacts_and_referees_are_not_on_public_pages_even_for_admins()
    {
        $params = $this->parameters();
        $this->actingAs(User::role('super_admin')->firstOrFail());

        $this->get("/clubs/{$params['club']}")->assertStatus(200)->assertDontSee('Ansprechpartner');
        $this->get('/infos')->assertDontSee('Diese Daten sind nur für Admins');
        $this->get("/fixtures/{$params['fixture']}")->assertStatus(200)->assertDontSee('fill: #fff" width="35"', false);
    }

    public function test_new_matchweek_gets_the_next_number_as_value()
    {
        $params = $this->parameters();
        $this->actingAs(User::role('super_admin')->firstOrFail());
        $season = \HLW\Season::findOrFail($params['season']);
        $next = $season->matchweeks()->max('number_consecutive') + 1;

        $this->get("/admin/seasons/{$season->id}/matchweeks/create")
            ->assertStatus(200)
            ->assertSee('name="number_consecutive" id="number_consecutive" aria-describedby="number_consecutiveHelp" value="'.$next.'"', false);
    }
}
