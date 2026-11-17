<form class="form-inline mb-4" method="GET" action="{{ url()->current() }}">
    <label class="mr-2" for="season_id">Saison</label>
    <select class="form-control mr-2" id="season_id" name="season_id" onchange="this.form.submit()">
        @foreach ($division->seasons()->orderBy('end', 'desc')->get() as $s)
            <option value="{{ $s->id }}" {{ $season && $season->id == $s->id ? 'selected' : null }}>{{ $s->name }}</option>
        @endforeach
    </select>
    <noscript><button type="submit" class="btn btn-secondary">Anzeigen</button></noscript>
</form>
