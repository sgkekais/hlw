<?php

namespace HLW\Http\Controllers\Admin;

use Illuminate\Http\Request;
use HLW\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    /**
     * Assign permission middleware to specific actions
     * PermissionController constructor.
     */
    public function __construct()
    {
        // Permissions
        $this->middleware('permission:list permissions')->only('index');
        $this->middleware('permission:create permission')->only([
            'create',
            'store']);
        $this->middleware('permission:update permission')->only([
            'edit',
            'update'
        ]);
        $this->middleware('permission:delete permission')->only('destroy');
    }

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
            'name'          =>  'required|unique:permissions',
            'description'   =>  'nullable'
        ]);

        $permission = new Permission([
            'name'          =>  $request->name,
            'description'   =>  $request->description
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
        $roles = Role::all();
        $permission->load('roles');

        return view('admin.permissions.edit', compact('permission', 'roles'));
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
        $this->validate($request, [
            'name'          =>  'required',
            'description'   =>  'nullable'
        ]);

        // only retrieve the name and description fields
        $input = $request->only(['name', 'description']);
        // update user
        $permission->fill($input)->save();

        // retrieve all selected roles
        $roles = $request['roles'];

        if (isset($roles)) {
            $permission->roles()->sync($roles);  //If one or more role is selected associate user to roles
        }
        else {
            $permission->roles()->detach(); // If no role is selected remove existing roles associated to the user
        }

        return redirect()->route('users.index')
            ->with('success', 'Berechtigung erfolgreich aktualisiert.');

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
