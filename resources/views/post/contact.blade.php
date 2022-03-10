@extends('layouts.app')

@section('content')

    <section class="content container">
        @include('layouts.partials.messages')

        <div class="row mb-4">
            <div class="col-md-6 mt-4">
                <h1>Contact Me</h1>
            </div>
        </div>
        <div class="row blog-entries">
            <div class="col-md-12 col-lg-8 main-content">
                <form action="{{route('contactMessage')}}" method="POST">
                    @method('post')
                    @csrf
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="name" class="col-md-4 control-label">Name *</label>
                            <div class="col-md-12">
                                <input id="name" type="text"
                                       class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name" value="{{ old('name') }}">

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="phone" class="col-md-4 control-label">Phone number</label>
                            <div class="col-md-12">
                                <input id="phone" type="text"
                                       class="form-control {{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                       name="phone" value="{{ old('phone') }}">

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="email" class="col-md-4 control-label">E-Mail Address *</label>

                            <div class="col-md-12">
                                <input id="email" type="email"
                                       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                       name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="country" class="col-md-4 col-form-label">{{ __('Country *') }}</label>
                            <div class="col-md-12">
                                <select class="form-select @error('country') is-invalid @enderror select2"
                                        name="country"
                                        id="country">
                                    <option value="">Please select your country</option>
                                    @foreach($countries as $key => $name)
                                        <option value="{{$key}}">{{$name}}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="message" class="col-md-4 control-label">Message *</label>
                            <div class="col-md-12">
                                 <textarea name="message" id="message"
                                           class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }} "
                                           cols="30"
                                           rows="8">{{ old('message') }}</textarea>
                                @if ($errors->has('message'))
                                    <span class="invalid-feedback">{{ $errors->first('message') }}</span>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group mt-2">
                            <input type="submit" value="Send Message" class="btn btn-primary">
                        </div>
                    </div>
                </form>
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
