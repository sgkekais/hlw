@extends('layouts.app')

@section('content')

    <div class="container-fluid h-100 bg-light">
        <div class="row h-75 justify-content-center d-flex align-items-center pt-4 pb-4">
            <div class="col-12 col-md-9 col-lg-6">
                <div class="card" style="border: 1px solid rgba(0, 0, 0, 0.15); border-radius: 0.25rem; -webkit-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);">
                    <div class="card-body">
                        <h1 class="font-weight-bold font-italic">Anmelden</h1>
                        <!-- Login Form -->
                        <form class="form" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label class="col-form-label" for="email">E-Mail</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-envelope-o"></i> </span>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus aria-describedby="mailHelp" placeholder="{{ old('email','name@mail.de') }}">
                                </div>
                                @if ($errors->has('email'))
                                    <div class="form-control-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password" class="">Passwort</label>
                                <div class="input-group">
                                    <div class="input-group-addon"><span class="fa fa-fw fa-unlock-alt"></span></div>
                                    <input id="password" type="password" class="form-control" name="password" required aria-describedby="passwordHelp" placeholder="{{ old('password','Passwort eingeben') }}">
                                </div>
                                @if ($errors->has('password'))
                                    <div class="form-control-feedback" id="passwordError">
                                        {{ $errors->first('password') }}
                                    </div>
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
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-sign-in"></span> Login
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
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