@extends('layouts.app')

@section('content')

    <section class="mt-10 mb-10 content container">

        @include('layouts.partials.messages')

        <div class="row mt-4">
            <div class="col-12">

                <form class="form-horizontal" method="POST" action="{{ route('articleStore') }} "
                      enctype="multipart/form-data"
                      id="create-submission">
                    {{ csrf_field() }}

                    <div class="d-block mt-4">
                        <h4> Add Article</h4>
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
                                <label for="category">Category*</label>
                                <select id="category" name="category" class="form-select select2">
                                    <option value=""> Select Category</option>
                                    @foreach($categories  as $key => $name)
                                        <option value="{{$key}}"> {{$name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category'))
                                    <span
                                        class="invalid-feedback d-block">{{ $errors->first('category') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="video_url">Link Video* (embed)</label>
                                <input id="video_url" type="text"
                                       class="form-control {{ $errors->has('video_url') ? ' is-invalid' : '' }}"
                                       name="video_url" placeholder="Video Url" value="{{ old('video_url') }}"
                                       required_>
                                @if ($errors->has('video_url'))
                                    <span class="invalid-feedback">{{ $errors->first('video_url') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="description">Description*</label>
                                <textarea
                                    rows="10"
                                    type="text"
                                    class="form-control rounded-0 {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                    name="description"
                                    required> {{ old('description') }}
                                </textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">{{ $errors->first('description') }}</span>
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
                                <a href="{{ url('/articles') }}" class="btn btn-outline-secondary">Back</a>
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
