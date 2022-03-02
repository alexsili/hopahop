@extends('layouts.app')

@section('content')

    <section class="mt-10 mb-10 content container">

        @include('layouts.partials.messages')

        <div class="row mt-4">
            <div class="col-12">

                <form class="form-horizontal" method="POST" action="{{ route('personageStore') }} "
                      enctype="multipart/form-data"
                      id="create-personage">
                    {{ csrf_field() }}

                    <div class="d-block mt-4">
                        <h4> Add Personage</h4>
                    </div>


                    <div class="d-block mt-4 pt-2 mr-5 pr-5">

                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="title">Name*</label>
                                <input id="title" type="text"
                                       class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name" placeholder="Name" value="{{ old('name') }}"
                                       required_>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="image">Personage Image File*</label>
                                <i class="fas fa-info-circle small mb-2" data-toggle="tooltip"
                                   title="The maximum size of file must be smaller than 30 MB"></i>
                                <input type="file"
                                       class="form-control"
                                       name="image"
                                       value="{{old('image')}}"
                                       placeholder="Image">
                                @if ($errors->has('image'))
                                    <span
                                        class="invalid-feedback d-block">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="required-fields text-right">
                            * required fields
                        </div>
                        <div class="input-group mt-4 ">
                            <div class="input-group w-1">
                                <input type="submit" value="Submit" class="btn btn-primary pull-right">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="spacer mt-4"></div>
        </div>
    </section>
@endsection

@section('endjs')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('select').select2({});
        });
    </script>
    <script type="text/javascript" src="{{ url('/js/submission.js') }}"></script>
@endsection
