@extends('admin.template-auth')
@section('title', 'HopaHop - Register')
@section('content')
    <main>
        @include('layouts.partials.messages')
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input
                                                class="form-control {{$errors->has('first_name') ? 'is-invalid' : ''}}"
                                                id="first_name" name="first_name" type="text"
                                                value="{{old('first_name')}}"
                                                placeholder="Enter your first name"/>
                                            <label for="first_name">First name*</label>
                                            @if($errors->has('first_name'))
                                                <span class="invalid-feedback"> {{$errors->first('first_name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input
                                                class="form-control {{$errors->has('last_name') ? 'is-invalid' : ''}}"
                                                id="last_name" name="last_name" type="text"
                                                value="{{old('last_name')}}"
                                                placeholder="Enter your last name"/>
                                            <label for="last_name">Last name*</label>
                                            @if($errors->has('last_name'))
                                                <span class="invalid-feedback"> {{$errors->first('last_name')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">

                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control {{$errors->has('email') ? 'is-invalid' : ''}}"
                                                   id="email" type="email" name="email"
                                                   value="{{old('email')}}"
                                                   placeholder="name@example.com"/>
                                            <label for="email">Email address*</label>
                                            @if($errors->has('email'))
                                                <span class="invalid-feedback"> {{$errors->first('email')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select
                                                class="form-select {{$errors->has('country') ? 'is-invalid' : ''}} select2"
                                                name="country" id="country">
                                                <option value=""></option>
                                                @foreach($countries as $key=> $name)
                                                    <option value="{{$key}}">{{$name}}</option>
                                                @endforeach
                                            </select>
                                            <label for="country">Select Country*</label>
                                            @if($errors->has('country'))
                                                <span class="invalid-feedback"> {{$errors->first('country')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input
                                                class="form-control  {{$errors->has('password') ? 'is-invalid' : ''}}"
                                                id="password" type="password" name="password"
                                                placeholder="Create a password"/>
                                            <label for="password">{{__('Password')}}</label>
                                            @if($errors->has('password'))
                                                <span class="invalid-feedback"> {{$errors->first('password')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input
                                                class="form-control  {{$errors->has('password') ? 'is-invalid' : ''}}"
                                                id="password-confirm" type="password" name="password_confirmation"
                                                placeholder="Confirm password"/>
                                            <label for="inputPasswordConfirm">{{__('Confirm Password')}}</label>
                                            @if($errors->has('password'))
                                                <span class="invalid-feedback"> {{$errors->first('password')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center py-3">
                            <div class="small"><a href="{{route('login')}}">Have an account? Go to login</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
{{--@section('js')--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('select').select2({});--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
