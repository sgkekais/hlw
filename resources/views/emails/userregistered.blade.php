Ein neuer User hat sich registriert.
<br><br>
Name: {{ $user->name }}
<br>
E-Mail: {{ $user->email }}
<br><br>
Favoriten:
<ul>
    @foreach ($user->clubs as $club)
        <li>{{ $club->name }}</li>
    @endforeach
</ul>