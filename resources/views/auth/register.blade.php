@extends('layouts.login')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-1 text-center pt-3 pb-3">
                                    <a href="/"><img src="{{ asset('images/logo.png') }}" class="logo"
                                                     alt="{{ config('app.name') }}" title="{{ config('app.name') }}"
                                                     style="width: 200px;"></a>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-1 text-center pt-3 pb-3">
                                    <h3>Create your new account with HopaHop</h3>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-1 pt-1 pb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="first_name"
                                                   class="col-md-12 col-form-label">{{ __('First Name') }}</label>

                                            <div class="col-md-12">
                                                <input id="first_name" type="text"
                                                       class="form-control @error('first_name') is-invalid @enderror"
                                                       name="first_name" value="{{ old('first_name') }}"
                                                       required
                                                       autocomplete="first_name" autofocus>

                                                @error('first_name')
                                                <span class="invalid-feedback"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="last_name"
                                                   class="col-md-12 col-form-label">{{ __('Last Name') }}</label>

                                            <div class="col-md-12">
                                                <input id="last_name" type="text"
                                                       class="form-control @error('last_name') is-invalid @enderror"
                                                       name="last_name" value="{{ old('last_name') }}" required
                                                       autocomplete="last_name">

                                                @error('last_name')
                                                <span class="invalid-feedback"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="country"
                                                   class="col-md-12 col-form-label">{{ __('Country') }}</label>

                                            <div class="col-md-12">
                                                <select
                                                    class="form-select @error('country') is-invalid @enderror select2"
                                                    name="country" id="country">
                                                    <option value="">Please select</option>
                                                    @foreach ($countries as $cid => $country)
                                                        <option value="{{$cid}}"> {{$country}} </option>
                                                    @endforeach
                                                </select>
                                                @error('country')
                                                <span class="invalid-feedback"
                                                      role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-3">
                                <div class="col-md-10 offset-md-1 pt-1 pb-3">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="email"
                                                   class="col-md-12 col-form-label">{{ __('E-Mail Address') }}</label>

                                            <div class="col-md-12">
                                                <input id="email" type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       name="email" value="{{ old('email') }}" required
                                                       autocomplete="email">

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="password" class="col-md-12 col-form-label">{{ __('Password') }}
                                                <i class="fas fa-info-circle small mb-2" data-toggle="tooltip"
                                                   title="The password must be at least 8 characters."
                                                   style="color: #666666;"></i></label>
                                            <div class="col-md-12">
                                                <input id="password" type="password"
                                                       class="form-control @error('password') is-invalid @enderror"
                                                       name="password" required autocomplete="new-password">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="password-confirm"
                                                   class="col-md-12 col-form-label">{{ __('Confirm Password') }}
                                            </label>

                                            <div class="col-md-12">
                                                <input id="password-confirm" type="password" class="form-control"
                                                       name="password_confirmation" required
                                                       autocomplete="new-password">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5 mb-2">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('SIGNUP') }}
                                    </button>
                                </div>
                                <div class="col-md-12 mt-3 mb-4 text-center font12">
                                    All fields are mandatory.
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-12 text-center pt-3 pb-0 register-link-wrapper">
                                    <a href="{{ route('login') }}"><strong>Already member of HopaHop? Login
                                            here!</strong></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('endjs')

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script>
        $(document).ready(function () {
            $('select').select2({});
        });
    </script>
@endsection
