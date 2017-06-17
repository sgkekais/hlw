@extends('admin.adminlayout')

@section('content')

    <div class="container">
        <table class="table table-condensed table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th></th>
                    <th>User</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($log as $entry)
                    <tr>
                        <td>{{ $entry->id }}</td>
                        <td>{{ $entry }}</td>
                        <td>
                            @if($entry->causer)
                                User ja
                            @else
                                User Nein
                            @endif
                        </td>
                        <td>Datum</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
