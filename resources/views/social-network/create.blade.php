@extends('layouts.app')

@section('content')

    <section class="mt-10 mb-10 content container">

        @include('layouts.partials.messages')

        <div class="row mt-4">
            <div class="col-12">

                <form class="form-horizontal" method="POST" action="{{ route('SocialNetworkStore') }} "
                      enctype="multipart/form-data"
                      id="create-submission">
                    {{ csrf_field() }}

                    <div class="d-block mt-4">
                        <h4> Add Social Network</h4>
                    </div>


                    <div class="d-block mt-4 pt-2 mr-5 pr-5">

                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="name">Name*</label>
                                <input id="name" type="text"
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
                                <label for="url">Url</label>
                                <input id="url" type="text"
                                       class="form-control {{ $errors->has('url') ? ' is-invalid' : '' }}"
                                       name="url" placeholder="Url" value="{{ old('url') }}"
                                       required_>
                                @if ($errors->has('url'))
                                    <span class="invalid-feedback">{{ $errors->first('url') }}</span>
                                @endif
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="{{ url('/social-network') }}" class="btn btn-outline-secondary">Back</a>
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
