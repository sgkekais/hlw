<?php

namespace Tests\Feature;

use HLW\Card;
use HLW\Club;
use HLW\Competition;
use HLW\Contact;
use HLW\DivisionOfficial;
use HLW\Fixture;
use HLW\Goal;
use HLW\Person;
use HLW\Position;
use HLW\Referee;
use HLW\Season;
use HLW\Stadium;
use HLW\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Characterization tests for the upgrade: every GET page of the public site
 * and the admin area has to render with status 200 against a copy of the
 * production database. Run them before and after each upgrade step.
 */
class SmokeTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Routes that are not part of the comparison: removed during the upgrade
     * (forum, public accounts, csv import, player passports), debug tools,
     * or known to be broken already (calendar, see TODO in routes/web.php).
     */
    const EXCLUDED = [
        '#^(login|logout|register|password|profile|email-verification)\b#',
        '#^(forum|discussion|category|posts)\b#',
        '#^(api|_debugbar|_ignition)\b#',
        '#^admin/(calendar)$#',
        '#playerpassports|/pdf(-debug)?$#',
    ];

    /**
     * Pages that already fail in production (Laravel 5.7, November 2026).
     * They are not linked anywhere in the UI. Remove an entry once it is
     * fixed or the route is dropped, so the test catches it again.
     */
    const KNOWN_BROKEN = [
        // show() of nested resources gets the parent id instead of the model
        '#^admin/fixtures/\{fixture\}/cards/\{card\}$#',
        '#^admin/fixtures/\{fixture\}/goals/\{goal\}$#',
        '#^admin/clubs/\{club\}/players/\{player\}$#',
        '#^admin/clubs/\{club\}/contacts/\{contact\}$#',
        // view links to the undefined route matchweeks.create
        '#^admin/seasons/\{season\}/matchweeks$#',
        // edit view calls format() on an empty date of the record
        '#^admin/divisions-official/\{divisions_official\}/edit$#',
    ];

    private $params;

    public function test_public_pages_render()
    {
        $failures = $this->requestAll(function ($uri) {
            return strpos($uri, 'admin') !== 0;
        });

        $this->assertSame([], $failures, "Public pages failing:\n" . implode("\n", $failures));
    }

    public function test_admin_pages_render()
    {
        $admin = User::role('super_admin')->firstOrFail();
        $this->actingAs($admin);

        $failures = $this->requestAll(function ($uri) {
            return strpos($uri, 'admin') === 0;
        });

        $this->assertSame([], $failures, "Admin pages failing:\n" . implode("\n", $failures));
    }

    public function test_admin_area_requires_login()
    {
        $this->get('/admin')->assertRedirect();
    }

    /**
     * Request every matching GET route and collect the ones that do not return 200.
     */
    private function requestAll(callable $filter)
    {
        $failures = [];
        $count = 0;
        $skipped = 0;

        foreach (Route::getRoutes() as $route) {
            $uri = $route->uri();

            if (!in_array('GET', $route->methods()) || !$filter($uri)
                || $this->matchesAny(self::EXCLUDED, $uri) || $this->matchesAny(self::KNOWN_BROKEN, $uri)) {
                continue;
            }

            // no record to show, e.g. an empty table
            $url = $this->fillParameters($uri);
            if ($url === null) {
                $skipped++;
                continue;
            }

            $status = $this->get($url)->getStatusCode();
            $count++;

            if ($status !== 200) {
                $failures[] = "$status  $url";
            }
        }

        $this->assertGreaterThan(0, $count, 'No routes were requested.');
        fwrite(STDERR, sprintf("\n  %d pages requested, %d failing, %d skipped (no record)\n", $count, count($failures), $skipped));

        return $failures;
    }

    private function matchesAny(array $patterns, $uri)
    {
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $uri)) {
                return true;
            }
        }

        return false;
    }

    private function fillParameters($uri)
    {
        $params = $this->parameters();

        $url = preg_replace_callback('/\{(\w+)\??\}/', function ($m) use ($params) {
            return array_key_exists($m[1], $params) && $params[$m[1]] !== null ? $params[$m[1]] : '__missing__';
        }, $uri);

        return strpos($url, '__missing__') === false ? '/' . ltrim($url, '/') : null;
    }

    /**
     * Route parameter values taken from one consistent set of real records:
     * a fixture of the current season with goals, cards and referees.
     */
    private function parameters()
    {
        if ($this->params !== null) {
            return $this->params;
        }

        $season = Season::current()->whereHas('fixtures.goals')->orderBy('id', 'desc')->first()
            ?: Season::whereHas('fixtures.goals')->orderBy('id', 'desc')->firstOrFail();

        $fixture = $season->fixtures()->has('goals')->has('cards')->has('referees')->orderBy('datetime', 'desc')->first()
            ?: $season->fixtures()->has('goals')->orderBy('datetime', 'desc')->firstOrFail();

        $club = $fixture->clubHome;
        $player = $club->players()->first();

        return $this->params = [
            'season'             => $season->id,
            'division'           => $season->division_id,
            'competition'        => optional($season->division)->competition_id ?: optional(Competition::first())->id,
            'matchweek'          => $fixture->matchweek_id,
            'fixture'            => $fixture->id,
            'club'               => $club->id,
            'player'             => optional($player)->id,
            'person'             => optional(optional($player)->person)->id ?: optional(Person::first())->id,
            'contact'            => optional($club->contacts()->first() ?: Contact::first())->id,
            'stadium'            => optional($club->stadiums()->first() ?: Stadium::first())->id,
            'referee'            => optional($fixture->referees()->first() ?: Referee::first())->id,
            'card'               => optional($fixture->cards()->first() ?: Card::first())->id,
            'goal'               => optional($fixture->goals()->first() ?: Goal::first())->id,
            'position'           => optional(Position::first())->id,
            'divisions_official' => optional(DivisionOfficial::first())->id,
            'user'               => optional(User::first())->id,
            'role'               => optional(Role::first())->id,
            'permission'         => optional(Permission::first())->id,
        ];
    }
}
