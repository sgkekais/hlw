@include('admin._includes.head')

<div id="app">
    <div class="container">

        <div class="row justify-content-center">
            <h1 class="mt-4 mb-4 pb-4">Login</h1>
        </div>

        <!-- Login Form -->
        <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} row justify-content-center">
                <label for="email" class="col-md-1 col-form-label ml-0 pl-0">E-Mail</label>
                <div class="col-md-4 input-group">
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
                <label for="password" class="col-md-1 col-form-label ml-0 pl-0">Passwort</label>
                <div class="col-md-4 input-group">
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
                <div class="col-md-1 ml-0 pl-0"></div>
                <div class="checkbox col-md-4">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Merken
                    </label>
                </div>
            </div>

            <div class="form-group row justify-content-center">
                <div class="col-md-1 ml-0 pl-0"></div>
                <div class="col-md-4">
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
@include('admin._includes.footer')
