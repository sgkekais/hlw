@extends('layouts.app')

@section('title')

    Profil

@endsection

@section('content')

    <div class="container pt-4">
        <div class="row">
            <div class="col-12">
                <h1 class="font-weight-bold font-italic">Hallo, {{ Auth::user()->name }}!</h1>
            </div>
        </div>

        <div class="row">
            {{-- account details --}}
            <div class="col-12 col-md-6">
                <h2 class="font-weight-bold font-italic text-uppercase">Account</h2>
                <form class="" method="POST" action="{{ route('frontend.user.profile.update') }}">
                    {{ csrf_field() }}

                    <div class="form-group row">
                        <label for="name" class="col-form-label col-sm-2">Name</label>
                        <input id="name" type="text" readonly class="col-sm-10 form-control-plaintext text-muted" value="{{ Auth::user()->name }}">
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-form-label col-sm-2">E-Mail</label>
                        <div class="col-sm-10">
                            <input id="email" type="email" readonly class="form-control-plaintext text-muted" value="{{ Auth::user()->email }}">
                            <small class="form-text text-muted">
                                Deine E-Mail wird nicht öffentlich angezeigt.
                            </small>
                        </div>
                    </div>

                    <div class="form-group">
                        <h4>Möchtest du dein Passwort ändern?</h4>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-form-label col-sm-2">Passwort</label>
                        <div class="col-sm-10">
                            <input id="password" type="password" class="form-control" name="password" required aria-describedby="passwordHelp">
                            <small id="passwordHelp" class="form-text text-muted">
                                Dein Passwort muss mindestens 6 Zeichen lang sein.
                            </small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-form-label col-sm-2">Bestätigen</label>
                        <div class="col-sm-10">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                    @if ($errors->has('password'))
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <span class="fa fa-fw fa-exclamation-circle"></span> {{ $errors->first('password') }}
                            </div>
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="form-group">
                            <div class="alert alert-success">
                                <span class="fa fa-fw fa-check-circle"></span> {{ Session::get('success') }}
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <span class="fa fa-fw fa-save"></span> Speichern
                        </button>
                    </div>
                </form>
            </div>
            {{-- favorite teams --}}
            <div class="col-12 col-md-6">
                <h2 class="font-weight-bold font-italic text-uppercase">Favoriten</h2>
                <h4 class="font-weight-bold font-italic">Favorit hinzufügen</h4>
                <div class="row">
                    <div class="col">
                        @if (!$clubs->isEmpty())
                            <form class="form-inline" method="POST" action="{{ route('frontend.user.profile.club.add') }}">
                                {{ csrf_field() }}
                                <select id="club" name="club" class="form-control mr-4">
                                    @foreach ($clubs->sortBy('name') as $club)
                                        <option value="{{ $club->id }}">{{ $club->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-success">
                                    <i class="fa fa-heart"></i> Hinzufügen
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                @if (Auth::user()->clubs->count() > 0)
                    <div class="row mt-3">
                        <div class="col">
                            <h4 class="font-weight-bold font-italic">Zugeordnete Favoriten</h4>
                        </div>
                    </div>
                    @foreach (Auth::user()->clubs->sortBy('name') as $club)
                        <div class="row mt-2">
                            <div class="col-2 pr-0 text-center">
                                @if($club->logo_url)
                                    <img src="{{ asset('storage/'.$club->logo_url) }}" class="img-fluid" title="{{ $club->name }}" alt="Vereinswappen">
                                @else
                                    <span class="fa fa-ban text-muted fa-5x"></span>
                                @endif
                            </div>
                            <div class="col-10 d-flex align-items-center justify-content-between">
                                <a href="{{ route('frontend.clubs.show', $club) }}" class="" title="zur Mannschaftsseite">
                                    <span class="d-block d-lg-none">{{ $club->name_short }}</span>
                                    <span class="d-none d-lg-block">{{ $club->name }}</span>
                                </a>
                                {{-- delete an assignment --}}
                                <form class="" method="POST" action="{{ route('frontend.user.profile.club.delete', $club) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-sm btn-danger pull-right"><span class="fa fa-trash"></span> Löschen</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-info">
                        Füge eines oder mehrere Teams als Favorit(en) hinzu!
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection