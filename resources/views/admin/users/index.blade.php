@extends('admin.adminlayout')

@section('content')

    <h1 class="">User-Verwaltung</h1>
    <p>
        Verwaltung der User.
    </p>
    <hr>
    <!-- list all roles -->
    <div class="row">
        <div class="col">
            <h2 class="">Angelegte Rollen <span class="badge badge-secondary">{{ $roles->count() }}</span></h2>
        </div>
    </div>
    <div class="row">
        <div class="col">
            @role('super_admin')
                <a class="btn btn-success" href="{{ route('roles.create') }}" title="Rolle anlegen">
                <span class="fa fa-plus-square"></span> Rolle anlegen
                </a>
                <a class="btn btn-success" href="{{ route('permissions.create') }}" title="Berechtigung anlegen">
                    <span class="fa fa-plus-square"></span> Berechtigung anlegen
                </a>
            @endrole
        </div>
    </div>
    <div class="row mt-4">
        <div class="col">
            <table class="table table-sm table-striped table-hover">
                <thead class="thead-default">
                <tr>
                    <th class="">ID</th>
                    <th class="">Name</th>
                    <th class="">Guard</th>
                    <th class="">Berechtigung(en)</th>
                    <th class="">Aktionen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td class="align-middle"><b>{{ $role->id }}</b></td>
                        <td class="align-middle">
                            {{ $role->name }}
                        </td>
                        <td class="align-middle">
                            {{ $role->guard_name }}
                        </td>
                        <td class="align-middle">{{ $role->permissions->pluck('name') }}</td>
                        <td class="align-middle">
                            @role('super_admin')
                            <!-- edit -->
                            <a class="btn btn-primary" href="{{ route('roles.edit', $role) }}" title="Rolle bearbeiten">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                            </a>
                            @endrole
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <!-- list all users -->
    <div class="row">
        <div class="col">
            <h2 class="">Angelegte User <span class="badge badge-secondary">{{ $users->count() }}</span></h2>
        </div>
    </div>
    {{-- <div class="row ">
         <div class="col">
             <a class="btn btn-success" href="{{ route('users.create') }}" title="Rolle anlegen">
                 <span class="fa fa-plus-square"></span> User anlegen
             </a>
         </div>
     </div>--}}
    <div class="row mt-4">
        <div class="col">
            <table class="table table-sm table-striped table-hover">
                <thead class="thead-default">
                <tr>
                    <th class="">ID</th>
                    <th class="">Name</th>
                    <th class="">E-Mail</th>
                    <th class="">Rolle(n)</th>
                    <th class="">Verifiziert</th>
                    <th class="">Aktionen</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="align-middle"><b>{{ $user->id }}</b></td>
                        <td class="align-middle">
                            {{ $user->name }}
                        </td>
                        <td class="align-middle">
                            {{ $user->email }}
                        </td>
                        <td class="align-middle">{{ $user->roles()->pluck('name') }}</td>
                        <td class="align-middle">
                            {{ $user->isVerified() ? "Ja" : "Nein" }}
                        </td>
                        <td class="align-middle">
                            <!-- display details -->
                            <a class="btn btn-secondary" href="{{ route('users.show', $user) }}" title="User anzeigen">
                                <span class="fa fa-search-plus"></span>
                            </a>
                            <!-- edit -->
                            <a class="btn btn-primary" href="{{ route('users.edit', $user) }}" title="User bearbeiten">
                                <span class="fa fa-pencil-square-o" aria-hidden="true"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


@endsection