<?php

namespace HLW\Http\Controllers\Admin;

use HLW\User;

use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // TODO: method for banning, method for roles
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->get();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \HLW\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \HLW\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
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
        // validate name, email
        $this->validate($request, [
            'name'      => 'required|string|min:2|max:20|unique:users,name,'.$user->id,
            'email'     => 'required|string|email|max:255|unique:users,email,'.$user->id
        ]);

        // only retrieve the name and email fields
        $input = $request->only(['name', 'email']);
        // update user
        $user->fill($input)->save();

        // retrieve all selected roles
        $roles = $request['roles'];

        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        }
        else {
            $user->roles()->detach(); // If no role is selected remove existing roles associated to the user
        }

        return redirect()->route('users.index')
            ->with('success', 'User erfolgreich aktualisiert.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \HLW\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
