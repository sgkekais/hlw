@include('admin._partials.head')

<div id="app">
    <div class="container mt-4 pt-4">
        <div class="row mt-4 mb-4 justify-content-center">
            <img src="/images/hlwlogo.png" class="" height="" alt="HLW-Logo">
        </div>
        <div class="row mt-4 mb-4 justify-content-center">
            <h2>Admin</h2>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mx-auto">
                    <h3 class="card-header text-center">Login</h3>
                    <div class="card-block">
                        <!-- Login Form -->
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} row justify-content-center">
                                <label for="email" class="col-md-2 col-form-label">E-Mail</label>
                                <div class="col-md-10 input-group">
                                    <div class="input-group-addon">@</div>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus aria-describedby="mailHelp" placeholder="{{ old('email','name@mail.de') }}">
                                </div>
                                @if ($errors->has('email'))
                                    <div class="form-control-feedback">
                                        {{ $errors->first('email') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }} row justify-content-center">
                                <label for="password" class="col-md-2 col-form-label">Passwort</label>
                                <div class="col-md-10 input-group">
                                    <div class="input-group-addon"><span class="fa fa-key"></span></div>
                                    <input id="password" type="password" class="form-control" name="password" required aria-describedby="passwordHelp" placeholder="{{ old('password','Passwort eingeben') }}">
                                </div>
                                @if ($errors->has('password'))
                                    <div class="form-control-feedback" id="passwordError">
                                        {{ $errors->first('password') }}
                                    </div>
                                @endif
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-md-2"></div>
                                <div class="checkbox col-md-10">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Merken
                                    </label>
                                </div>
                            </div>

                            <div class="form-group row justify-content-center">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
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
</div>
@include('admin._partials.footer')
