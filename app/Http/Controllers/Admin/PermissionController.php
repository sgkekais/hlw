<?php

namespace HLW\Http\Controllers\Admin;

use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();

        return view('admin.permissions.create', compact('roles'));
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
           'name'   =>  'required|unique:permissions'
        ]);

        $permission = new Permission([
            'name'  =>  $request->name
        ]);

        $permission->save();

        if ($request->filled('roles')) {
            foreach ($request->roles as $role) {
                Role::find($role)->givePermissionTo($permission);
            }
        }

        return redirect()->route('users.index')->with('success', 'Berechtigung '.$permission->name.' erfolgreich angelegt.');
    }

    /**
     * Display the specified resource.
     *
     * @param Permission $permission
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     */
    public function edit(Permission $permission)
    {
        $permission->load('roles');

        return view('admin.permissions.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Permission $permission
     */
    public function update(Request $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
