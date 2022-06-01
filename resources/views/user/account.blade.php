@extends('layouts.app')

@section('content')
    <section class="mt-4 mb-10 content container">
        <h1 class="h2 mb-3">
            My Account
        </h1>
        <div class="row">
            <div class="col-md-12">
                @include('layouts.partials.messages')
                <div class="box">
                    <div class="box-body">
                        <form class="form-horizontal" method="POST" action="/account-update">
                            {{ csrf_field() }}
                            <section class="mt-10 mb-10 content container">

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <label for="first_name" class="col-md-4 control-label">First Name</label>

                                            <div class="col-md-6">
                                                <input id="first_name" type="text"
                                                       class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                                       name="first_name" value="{{ $user->first_name }}" required_>
                                                @if ($errors->has('first_name'))
                                                    <span
                                                        class="invalid-feedback">{{ $errors->first('first_name') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="last_name" class="col-md-4 control-label">Last Name</label>

                                            <div class="col-md-6">
                                                <input id="last_name" type="text"
                                                       class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                                       name="last_name" value="{{ $user->last_name }}" required_>

                                                @if ($errors->has('last_name'))
                                                    <span
                                                        class="invalid-feedback">{{ $errors->first('last_name') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                            <div class="col-md-6">
                                                <input id="email" type="email"
                                                       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                       name="email" value="{{ $user->email }}" required_>

                                                @if ($errors->has('email'))
                                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="country"
                                                   class="col-md-4 col-form-label">{{ __('Country') }}</label>
                                            <div class="col-md-6">
                                                <select
                                                    class="form-select @error('country') is-invalid @enderror select2"
                                                    name="country"
                                                    id="country" required_>
                                                    <option value="">Please select your country</option>
                                                    @foreach($countries as $key => $name)
                                                        <option @if($key == $user->country_id) selected
                                                                @endif value="{{$key}}">{{$name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('country')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row mt-4">
                                    <div class="col-md-12 text-start">
                                        <a href="{{ url('/users') }}" class="btn btn-outline-secondary">Back</a>
                                        <button type="submit" class="btn btn-large btn-primary">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </section>

                        </form>

                    </div><!-- /.box-body -->
                </div><!-- /.box -->


            </div>
        </div>
    </section>
@endsection

@section('endjs')
    <script>
        $(document).ready(function () {
            $('select').select2({});
        });
    </script>
@endsection

