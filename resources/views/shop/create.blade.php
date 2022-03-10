@extends('layouts.app')

@section('content')

    <section class="mt-10 mb-10 content container">

        @include('layouts.partials.messages')

        <div class="row mt-4">
            <div class="col-12">

                <form class="form-horizontal" method="POST" action="{{ route('shopStore') }} "
                      enctype="multipart/form-data"
                      id="create-submission">
                    {{ csrf_field() }}

                    <div class="d-block mt-4">
                        <h4> Add Shop Article</h4>
                    </div>


                    <div class="d-block mt-4 pt-2 mr-5 pr-5">

                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="title">Title*</label>
                                <input id="title" type="text"
                                       class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                       name="title" placeholder="Title" value="{{ old('title') }}"
                                       required_>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="url">Shop URL*</label>
                                <input id="url" type="text"
                                       class="form-control {{ $errors->has('url') ? ' is-invalid' : '' }}"
                                       name="url" placeholder="Shop Url" value="{{ old('url') }}"
                                       required_>
                                @if ($errors->has('url'))
                                    <span class="invalid-feedback">{{ $errors->first('url') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="image">Image File*</label>
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
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ url('/shop') }}" class="btn btn-outline-secondary">Back</a>
                                <button type="submit" class="btn btn-large btn-primary">
                                    Save
                                </button>
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
