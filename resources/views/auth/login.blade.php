@extends('layouts.login')

@section('content')
    <div class="container" id="login">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-1 text-center pt-3 pb-3">
                                    <a href="/"><img src="{{ asset('images/logo.png') }}" class="logo"
                                                     alt="{{ config('app.name') }}"
                                                     title="{{ config('app.name') }}"></a>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-10 offset-md-1 col-form-label">{{ __('Username (email address)') }}</label>

                                <div class="col-md-10 offset-md-1">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-12">
                                <label for="password"
                                       class="col-md-10 offset-md-1 col-form-label">{{ __('Password') }}</label>

                                <div class="col-md-10 offset-md-1">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mt-5 mb-4">
                                <div class="col-md-6 offset-md-1">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-10 offset-md-1 pt-3 pb-4 register-link-wrapper">
                                    <a href="{{ route('register') }}"><strong>New to HopaHop? Sign up here!</strong></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
