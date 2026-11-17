{{-- switch between scorers and sinners of the division, keeping the selected season --}}
<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a class="nav-link {{ Route::is('admin.divisions.scorers') ? 'active' : null }}" href="{{ route('admin.divisions.scorers', [$division, 'season_id' => optional($season)->id]) }}">
            <span class="fa fa-soccer-ball-o"></span> Torschützen
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Route::is('admin.divisions.sinners') ? 'active' : null }}" href="{{ route('admin.divisions.sinners', [$division, 'season_id' => optional($season)->id]) }}">
            <span class="fa fa-thumbs-o-down"></span> Sünderkartei
        </a>
    </li>
</ul>
