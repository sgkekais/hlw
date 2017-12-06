@extends('layouts.app')

@section('title')
    Registrieren
@endsection

@section('content')

    <div class="container-fluid h-100 bg-light">
        <div class="row h-75 justify-content-center d-flex align-items-center pt-4 pb-4">
            <div class="col-12 col-md-9 col-lg-6">
                <div class="card">
                    <div class="card-body" style="border: 1px solid rgba(0, 0, 0, 0.15); border-radius: 0.25rem; -webkit-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);">
                        <h1 class="font-weight-bold font-italic">Registrieren</h1>
                        <form class="" method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-form-label">Name</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-id-card-o"></i> </span>
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                </div>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-form-label">E-Mail Addresse</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-envelope-o"></i> </span>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-form-label">Passwort</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-unlock-alt"></i> </span>
                                    <input id="password" type="password" class="form-control" name="password" required aria-describedby="passwordHelp">
                                </div>
                                <small id="passwordHelp" class="form-text text-muted">
                                    Dein Passwort muss mindestens 6 Zeichen lang sein.
                                </small>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-form-label">Passwort bestätigen</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-lock"></i> </span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="clubs">Lieblingsverein(e)</label>
                                <select multiple class="form-control" id="clubs" name="clubs[]" aria-describedby="clubsHelp">
                                    @foreach ($clubs as $club)
                                        <option value="{{ $club->id }}">{{ $club->name }}</option>
                                    @endforeach
                                </select>
                                <small id="clubsHelp" class="form-text text-muted">
                                    Wähle deinen Lieblingsverein aus, um schnell auf diesen zugreifen zu können. Mit gehaltener STRG-Taste kannst du auch mehrere Mannschaften auswählen.
                                </small>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <span class="fa fa-fw fa-user-plus"></span> Registrieren!
                                </button>
                                <a class="btn btn-link" href="{{ route('login') }}">
                                    Bereits registriert?
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection