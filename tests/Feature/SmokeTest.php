<?php

namespace Tests\Feature;

use HLW\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Route;
use Tests\Concerns\UsesRealRecords;
use Tests\TestCase;

/**
 * Characterization tests for the upgrade: every GET page of the public site
 * and the admin area has to render with status 200 against a copy of the
 * production database. Run them before and after each upgrade step.
 */
class SmokeTest extends TestCase
{
    use DatabaseTransactions, UsesRealRecords;

    /**
     * Routes that are not part of the comparison: debug tools, the login form
     * (tested separately), or known to be broken already (calendar, see TODO
     * in routes/web.php).
     */
    const EXCLUDED = [
        '#^(api|_debugbar|_ignition)\b#',
        '#^admin/(calendar|login)$#',
    ];

    /**
     * Public pages that were removed: forum, accounts, registration, password reset.
     */
    const REMOVED = [
        '/login', '/register', '/password/reset', '/profile',
        '/email-verification/error', '/forum',
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

    public function test_public_pages_render()
    {
        // render the pages with personal data too, they can be switched on again
        config(['hlw.public_personal_data' => true]);

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
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->get('/admin/login')->assertStatus(200)->assertSee('Admin-Login');
    }

    public function test_only_admins_can_log_in()
    {
        $admin = User::role('admin')->firstOrFail();
        $admin->forceFill(['password' => bcrypt('smoke-test')])->save();
        $member = User::role('member')->whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['admin', 'super_admin']);
        })->firstOrFail();
        $member->forceFill(['password' => bcrypt('smoke-test')])->save();

        $this->post('/admin/login', ['email' => $member->email, 'password' => 'smoke-test'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'wrong'])
            ->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'smoke-test'])
            ->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);

        $this->post('/admin/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_members_are_locked_out_of_the_admin_area()
    {
        $member = User::role('member')->whereDoesntHave('roles', function ($query) {
            $query->whereIn('name', ['admin', 'super_admin']);
        })->firstOrFail();

        $this->actingAs($member)->get('/admin')->assertStatus(403);
    }

    public function test_removed_public_pages_are_gone()
    {
        foreach (self::REMOVED as $url) {
            $this->assertSame(404, $this->get($url)->getStatusCode(), $url);
        }
    }

    public function test_personal_data_is_hidden_by_default()
    {
        $params = $this->parameters();

        $this->get("/division/{$params['division']}/scorers")->assertStatus(404);
        $this->get("/division/{$params['division']}/sinners/ajax-sinners")->assertStatus(404);
        $this->get("/division/{$params['division']}")->assertStatus(200)->assertDontSee('Torjäger')->assertDontSee('TORSCHÜTZEN');
        $this->get("/clubs/{$params['club']}")->assertStatus(200)->assertDontSee('id="players-tab"', false);
        $this->get("/fixtures/{$params['fixture']}")->assertStatus(200)->assertDontSee('Gemeldete Torschützen');
    }

    public function test_personal_data_can_be_switched_on()
    {
        config(['hlw.public_personal_data' => true]);
        $params = $this->parameters();

        $this->get("/division/{$params['division']}/scorers")->assertStatus(200);
        $this->get("/division/{$params['division']}")->assertStatus(200)->assertSee('Torjäger');
        $this->get("/clubs/{$params['club']}")->assertStatus(200)->assertSee('id="players-tab"', false);
        $this->get("/fixtures/{$params['fixture']}")->assertStatus(200)->assertSee('Gemeldete Torschützen');
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
}
