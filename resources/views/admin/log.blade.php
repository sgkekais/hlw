@extends('admin.adminlayout')

@section('content')

    <table class="table table-condensed table-hover table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th></th>
                <th>Model</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($log as $entry)
                <tr>
                    <td>{{ $entry->id }}</td>
                    <td>{{ $entry->updated_at->diffForHumans() }}</td>
                    <td>
                        {{ $entry->subject_type }} |
                        {{ $entry->description  }}
                        @if($entry-)
                    </td>
                    <td>
                        @if($entry->causer)
                            {{ $entry->causer->name }}
                        @else
                            Non-User
                        @endif
                    </td>
                    <td>Datum</td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
