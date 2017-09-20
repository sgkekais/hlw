@extends('admin._partials.head')

<div id="app">
    <div class="container">
        <div class="row justify-content-center">
            <img src="/images/hlwlogo.png" class="" height="" alt="HLW-Logo">
        </div>
        <div class="row mt-4 mb-4 justify-content-center">
            <h2>Admin</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Login Form -->
                <form class="form" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} row">
                        <label for="email">E-Mail</label>
                        <div class="input-group">
                            <div class="input-group-addon">@</div>
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus aria-describedby="mailHelp" placeholder="{{ old('email','name@mail.de') }}">
                        </div>
                        @if ($errors->has('email'))
                            <div class="form-control-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }} row">
                        <label for="password" class="">Passwort</label>
                        <div class="input-group">
                            <div class="input-group-addon"><span class="fa fa-key"></span></div>
                            <input id="password" type="password" class="form-control" name="password" required aria-describedby="passwordHelp" placeholder="{{ old('password','Passwort eingeben') }}">
                        </div>
                        @if ($errors->has('password'))
                            <div class="form-control-feedback" id="passwordError">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group row">
                        <div class=""></div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Merken
                            </label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class=""></div>
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