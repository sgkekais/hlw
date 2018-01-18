@extends('layouts.app')

@section('content')

    <div class="container-fluid h-100 bg-light">
        <div class="row h-75 justify-content-center d-flex align-items-center pt-4 pb-4">
            <div class="col-12 col-md-9 col-lg-6">
                <div class="card" style="border: 1px solid rgba(0, 0, 0, 0.15); border-radius: 0.25rem; -webkit-box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);">
                    <div class="card-body">
                        <h1 class="font-weight-bold font-italic">Passwort zurücksetzen</h1>

                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="form" method="POST" action="{{ route('password.email') }}">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="email" class="col-form-label">E-Mail</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-fw fa-envelope-o"></i></span>
                                    </div>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                </div>

                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-fw fa-envelope-o"></i> Passwort-Link senden
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
