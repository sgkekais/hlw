@extends('layouts.app')

@section('content')

    <div class="container-fluid h-100 bg-light">
        <div class="row h-75 justify-content-center d-flex align-items-center pt-4 pb-4">
            <div class="col-12 col-md-9 col-lg-6">
                <div class="card" style="border: 1px solid rgba(0, 0, 0, 0.15); border-radius: 0.25rem; -webkit-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);">
                    <div class="card-body">
                        <h1 class="font-weight-bold font-italic">Passwort zurücksetzen</h1>

                            <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="token" value="{{ $token }}">

                                <div class="form-group">
                                    <label for="email" class="col-form-label">E-Mail</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-fw fa-envelope-o"></i></span>
                                        </div>
                                        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-form-label">Passwort</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-fw fa-unlock-alt"></i></span>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-form-label">Passwort wiederholen</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-fw fa-unlock-alt"></i></span>
                                        </div>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                        @if ($errors->has('password_confirmation'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">
                                        <span class="fa fa-fw fa-save"></span> Passwort zurücksetzen
                                    </button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
