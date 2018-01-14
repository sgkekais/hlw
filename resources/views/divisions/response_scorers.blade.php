<div class="row">
    <div class="col">
        @if (!$scorers->isEmpty())
            <table class="table table-hover">
                <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th class=""><span class="fa fa-user" title="Name"></span></th>
                    <th class=""><span class="fa fa-shield" title="Team"></span></th>
                    <th class=""><span class="fa fa-soccer-ball-o" title="Tore"></span></th>
                </tr>
                </thead>
                <tbody>
                @php
                    $rank = 1;
                @endphp
                @foreach ($scorers->sortByDesc('goals')->groupBy('goals') as $scorer_group)
                    @php
                        $count_scorers = $scorer_group->count();
                    @endphp
                    {{-- outer loop --}}
                    @foreach($scorer_group->sortBy('person.last_name') as $scorer)
                        {{-- inner loop --}}
                        <tr>
                            <td class="text-center">
                                @if ($loop->first)
                                    {{ $rank }}
                                    @if ($count_scorers > 1)
                                        <small class="text-muted">({{ $count_scorers }})</small>
                                    @endif
                                @endif
                            </td>
                            <td>{{ $scorer->person->full_name_shortened }}</td>
                            <td>{{ $scorer->club->name }}</td>
                            <td>{{ $scorer->goals }}</td>
                        </tr>
                    @endforeach
                    @php
                        $rank += $count_scorers;
                    @endphp
                @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">
                <span class="fa fa-fw fa-info-circle"></span> Noch keine Torschützen in dieser Saison erfasst.
            </div>
        @endif
    </div>
</div>
