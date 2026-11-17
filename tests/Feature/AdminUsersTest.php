<?php

namespace Tests\Feature;

use HLW\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\Permission\Models\Role;
use Tests\Concerns\UsesRealRecords;
use Tests\TestCase;

class AdminUsersTest extends TestCase
{
    use DatabaseTransactions, UsesRealRecords;

    public function test_super_admin_creates_an_admin_who_can_log_in()
    {
        $this->actingAs(User::role('super_admin')->firstOrFail());
        $role = Role::findByName('admin');

        $this->post('/admin/users', [
            'name' => 'Neuer Admin',
            'email' => 'neuer.admin@example.com',
            'password' => 'ein-langes-passwort',
            'password_confirmation' => 'ein-langes-passwort',
            'roles' => [$role->id],
        ])->assertRedirect('/admin/users')->assertSessionHasNoErrors();

        $user = User::where('email', 'neuer.admin@example.com')->firstOrFail();
        $this->assertTrue($user->hasRole('admin'));

        $this->post('/admin/logout');
        $this->post('/admin/login', ['email' => 'neuer.admin@example.com', 'password' => 'ein-langes-passwort'])
            ->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
    }

    public function test_passwords_need_twelve_characters_and_a_confirmation()
    {
        $this->actingAs(User::role('super_admin')->firstOrFail());

        $this->post('/admin/users', [
            'name' => 'Kurz', 'email' => 'kurz@example.com',
            'password' => 'zu-kurz', 'password_confirmation' => 'zu-kurz',
        ])->assertSessionHasErrors('password');

        $this->post('/admin/users', [
            'name' => 'Anders', 'email' => 'anders@example.com',
            'password' => 'ein-langes-passwort', 'password_confirmation' => 'ein-anderes-passwort',
        ])->assertSessionHasErrors('password');
    }

    public function test_super_admin_sets_a_new_password()
    {
        $this->actingAs(User::role('super_admin')->firstOrFail());
        $admin = User::role('admin')->firstOrFail();

        $this->patch("/admin/users/{$admin->id}", [
            'name' => $admin->name,
            'email' => $admin->email,
            'password' => 'das-neue-passwort',
            'password_confirmation' => 'das-neue-passwort',
            'roles' => $admin->roles->pluck('id')->all(),
        ])->assertRedirect('/admin/users')->assertSessionHasNoErrors();

        $this->assertTrue(password_verify('das-neue-passwort', $admin->fresh()->password));
        $this->assertTrue($admin->fresh()->hasRole('admin'));
    }

    public function test_an_empty_password_keeps_the_old_one()
    {
        $this->actingAs(User::role('super_admin')->firstOrFail());
        $admin = User::role('admin')->firstOrFail();
        $hash = $admin->password;

        $this->patch("/admin/users/{$admin->id}", [
            'name' => $admin->name,
            'email' => $admin->email,
            'password' => '',
            'password_confirmation' => '',
            'roles' => $admin->roles->pluck('id')->all(),
        ])->assertSessionHasNoErrors();

        $this->assertSame($hash, $admin->fresh()->password);
    }

    public function test_super_admin_deletes_users_but_not_himself()
    {
        $super = User::role('super_admin')->firstOrFail();
        $this->actingAs($super);
        $member = $this->createMember();

        $this->delete("/admin/users/{$member->id}")->assertRedirect('/admin/users');
        $this->assertNull(User::find($member->id));

        $this->delete("/admin/users/{$super->id}")->assertSessionHas('danger');
        $this->assertNotNull(User::find($super->id));
    }

    public function test_admins_cannot_manage_users_or_roles()
    {
        $admin = User::role('admin')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'super_admin');
        })->firstOrFail();
        $this->actingAs($admin);

        $this->get('/admin/users')->assertStatus(403);
        $this->get("/admin/users/{$admin->id}/edit")->assertStatus(403);
        $this->patch("/admin/users/{$admin->id}", ['name' => $admin->name, 'email' => $admin->email, 'roles' => Role::pluck('id')->all()])
            ->assertStatus(403);
        $this->get('/admin/roles/create')->assertStatus(403);
        $this->assertFalse($admin->fresh()->hasRole('super_admin'));
    }

    public function test_admins_see_scorers_and_sinners()
    {
        $admin = User::role('admin')->firstOrFail();
        $params = $this->parameters();

        $this->actingAs($admin)
            ->get("/admin/divisions/{$params['division']}/scorers?season_id={$params['season']}")
            ->assertStatus(200)
            ->assertSee('Torschützen');

        $this->get("/admin/divisions/{$params['division']}/sinners?season_id={$params['season']}")
            ->assertStatus(200)
            ->assertSee('Sünderkartei');
    }

    public function test_super_admins_cannot_lock_out_user_management()
    {
        $super = User::role('super_admin')->firstOrFail();
        $this->actingAs($super);
        $otherRoles = $super->roles->where('name', '!=', 'super_admin')->pluck('id')->all();

        // own account
        $this->from('/admin/users')->patch("/admin/users/{$super->id}", [
            'name' => $super->name, 'email' => $super->email, 'roles' => $otherRoles,
        ])->assertSessionHas('danger');
        $this->assertTrue($super->fresh()->hasRole('super_admin'));

        // the last super admin
        User::role('super_admin')->where('id', '!=', $super->id)->get()
            ->each(fn ($user) => $user->removeRole('super_admin'));
        $other = User::role('admin')->where('id', '!=', $super->id)->firstOrFail();
        $other->assignRole('super_admin');
        $this->actingAs($other);
        $super->removeRole('super_admin');

        $this->patch("/admin/users/{$other->id}", [
            'name' => $other->name, 'email' => $other->email, 'roles' => [],
        ])->assertSessionHas('danger');
        $this->assertTrue($other->fresh()->hasRole('super_admin'));
    }

    public function test_logins_from_one_ip_are_limited_across_e_mail_addresses()
    {
        for ($i = 0; $i < 20; $i++) {
            $this->post('/admin/login', ['email' => "unbekannt{$i}@example.com", 'password' => 'falsch']);
        }

        $this->post('/admin/login', ['email' => 'noch-einer@example.com', 'password' => 'falsch'])
            ->assertSessionHasErrors(['email' => 'Zu viele Anmeldeversuche. Bitte in 5 Minuten erneut versuchen.']);
    }
}
