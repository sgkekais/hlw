<?php

namespace HLW\Http\Controllers\Admin;

use HLW\User;

use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Only super admins manage the accounts of the admin area.
 */
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->orderBy('name')->get();
        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('description')->get();

        return view('admin.users.index', compact('users', 'roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('name')->get();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      => 'required|string|min:2|max:20|unique:users,name',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => ['required', 'confirmed', Password::min(12)],
            'roles'     => 'nullable|array',
            'roles.*'   => 'exists:roles,id',
        ]);

        $user = new User($request->only(['name', 'email']));
        $user->password = bcrypt($request->password);
        $user->save();

        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('users.index')
            ->with('success', 'User erfolgreich angelegt.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::orderBy('name')->get();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \HLW\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // validate name, email, an optional new password
        $this->validate($request, [
            'name'      => 'required|string|min:2|max:20|unique:users,name,'.$user->id,
            'email'     => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password'  => ['nullable', 'confirmed', Password::min(12)],
            'roles'     => 'nullable|array',
            'roles.*'   => 'exists:roles,id',
        ]);

        // the own account and the last super admin keep the role, otherwise nobody could manage users anymore
        $superAdmin = Role::findByName('super_admin');
        $removesSuperAdmin = $user->hasRole($superAdmin) && !in_array($superAdmin->id, $request->input('roles', []));
        if ($removesSuperAdmin && ($user->is($request->user()) || User::role($superAdmin)->count() === 1)) {
            return redirect()->back()->withInput()
                ->with('danger', 'Die Rolle super_admin kann dem eigenen und dem letzten Super-Admin nicht entzogen werden.');
        }

        // only retrieve the name and email fields
        $input = $request->only(['name', 'email']);
        // update user
        $user->fill($input);
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        // sync the selected roles, none removes all roles
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('users.index')
            ->with('success', 'User erfolgreich aktualisiert.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if ($user->is($request->user())) {
            return redirect()->back()->with('danger', 'Der eigene User kann nicht gelöscht werden.');
        }

        $user->roles()->detach();
        $user->permissions()->detach();
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User erfolgreich gelöscht.');
    }
}
