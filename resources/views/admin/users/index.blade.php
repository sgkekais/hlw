@extends('admin.adminlayout')

@section('content')

    <h1 class="">User</h1>
    <p>
        Verwaltung der User.
    </p>
    <div class="row">
        <div class="col-md-3">
            <!-- controls -->
            <a class="btn btn-success" href="{{ route('users.create') }}" title="User anlegen">
                <span class="fa fa-plus-square"></span> User anlegen
            </a>
        </div>
    </div>
    <hr>
    <!-- list all competitions -->
    <h2 class="mt-4">Angelegte User <span class="badge badge-secondary">{{ $users->count() }}</span></h2>
    <table class="table table-sm table-striped table-hover">
        <thead class="thead-default">
        <tr>
            <th class="">ID</th>
            <th class="">Name</th>
            <th class="">E-Mail</th>
            <th class="">Rollen</th>
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
                <td></td>
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

@endsection