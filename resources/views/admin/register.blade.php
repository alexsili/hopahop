@extends('admin.template-auth')
@section('title', 'HopaHop - Register')
@section('content')
    <main>
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
                                            <input class="form-control" id="first_name" name="first_name" type="text"
                                                   value="{{old('first_name')}}"
                                                   placeholder="Enter your first name"/>
                                            <label for="first_name">First name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" id="last_name" name="last_name" type="text"
                                                   value="{{old('last_name')}}"
                                                   placeholder="Enter your last name"/>
                                            <label for="last_name">Last name</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">

                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="email" type="email" name="email"
                                                   value="{{old('email')}}"
                                                   placeholder="name@example.com"/>
                                            <label for="email">Email address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-select" name="country" id="country">
                                                <option value=""></option>
                                                @foreach($countries as $key=> $name)
                                                    <option value="{{$key}}">{{$name}}</option>
                                                @endforeach
                                            </select>
                                            <label for="country">Select Country</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="password" type="password" name="password"
                                                   placeholder="Create a password"/>
                                            <label for="password">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputPasswordConfirm" type="password"
                                                   placeholder="Confirm password"/>
                                            <label for="inputPasswordConfirm">Confirm Password</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 mb-0">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Register') }}
                                    </button>
                                    {{--                                    <div class="d-grid"><a class="btn btn-primary btn-block" href="login.html">Create--}}
                                    {{--                                            Account</a></div>--}}
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
