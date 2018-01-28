@extends('layouts.app')

@section('title')
    - Login
@endsection

@section('content')

    <div class="container-fluid h-100 bg-light">
        <div class="row justify-content-center d-flex align-items-center pt-4 pb-4">
            <div class="col-12 col-md-9 col-lg-6">
                <div class="card" style="border: 1px solid rgba(0, 0, 0, 0.15); border-radius: 0.25rem; -webkit-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);">
                    <div class="card-body">
                        @if (session('registered'))
                            <div class="alert alert-info">
                                <h4><span class="fa fa-fw fa-envelope"></span> Registrierung erfolgreich!</h4>
                                    <p>
                                        {{ session('registered') }}
                                    </p>
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success">
                                <span class="fa fa-fw fa-check-circle-o"></span> {{ session('success') }}
                            </div>
                        @endif
                        @if (session('warning'))
                            <div class="alert alert-warning">
                                <span class="fa fa-fw fa-warning"></span> {{ session('warning') }}
                            </div>
                        @endif
                        <h1 class="font-weight-bold font-italic">Anmelden</h1>
                        <!-- Login Form -->
                        <form class="form" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-form-label" for="email">E-Mail</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-fw fa-envelope-o"></i></span>
                                    </div>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus aria-describedby="mailHelp" placeholder="{{ old('email','name@mail.de') }}">
                                </div>
                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password" class="">Passwort</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-fw fa-unlock-alt"></i></span>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" required aria-describedby="passwordHelp" placeholder="{{ old('password','Passwort eingeben') }}">
                                </div>
                                @if ($errors->has('password'))
                                    <span class="text-danger" id="passwordError">
                                        {{ $errors->first('password') }}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Merken?
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <button type="submit" class="btn btn-primary mr-1 mt-2">
                                        <span class="fa fa-sign-in"></span> Login
                                    </button>
                                    <a class="btn btn-outline-primary mr-1 mt-2" href="{{ route('register') }}" title="Registrieren">
                                        Neu hier? Registrier dich!
                                    </a>
                                    <a class="btn btn-link mt-2 pull-right" href="{{ route('password.request') }}" title="Passwort vergessen">
                                        Passwort vergessen?
                                    </a>
                                </div>
                            </div>
                        </form> <!-- ./Login Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection