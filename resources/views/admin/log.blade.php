@extends('admin.adminlayout')

@section('content')

    @if($log)
        <table class="table table-condensed table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Zeit</th>
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
                            @if($entry->description == "created")
                                <span class="badge badge-pill badge-success">Angelegt</span>
                            @elseif($entry->description == "updated")
                                <span class="badge badge-pill badge-warning">Geändert</span>
                            @elseif($entry->description == "deleted")
                                <span class="badge badge-pill badge-danger">Gelöscht</span>
                            @endif
                                {{ $entry->subject_type }} (ID: {{ $entry->subject_id }})
                            <br>
                            @if($entry->description == "updated")
                                @if($entry->changes)
                                    Neu:
                                    <ul>
                                        @foreach($entry->changes->get('attributes') as $key => $value)
                                            <li>{{ $key.": ".$value }}</li>
                                        @endforeach
                                    </ul>
                                    Alt:
                                    <ul>
                                        @foreach($entry->changes->get('old') as $key => $value)
                                            <li>{{ $key.": ".$value }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($entry->causer)
                                {{ $entry->causer->name }}
                            @else
                                Non-User
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection
