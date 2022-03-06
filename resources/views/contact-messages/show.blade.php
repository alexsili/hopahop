@extends('layouts.app')
@section('content')
    <section class="mt-10 mb-10 content container">

        <div class="row mt-4">
            <div class="col-12">

                @include('layouts.partials.messages')

                <form class="form-horizontal" action="{{ route('contactMessageResponse',$message->id) }}" method="POST"
                      enctype="multipart/form-data" id="update-personage">
                    @method('post')
                    {{ csrf_field() }}

                    <div class="d-block mt-4">
                        <h4> Contact Message</h4>
                    </div>

                    <div class="d-block mt-4 pt-2 mr-5 pr-5">

                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="name">Name: &nbsp; {{$message->name}}</label>
                            </div>
                        </div>
                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="name">Phone: &nbsp; {{$message->phone}}</label>
                            </div>
                        </div>
                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="name">Email: &nbsp; {{$message->email}}</label>
                            </div>
                        </div>
                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="name">Country: &nbsp; {{$message->country->name}}</label>
                            </div>
                        </div>
                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="name">Message: &nbsp; {{$message->message}}</label>
                            </div>
                        </div>

                    </div>
                    <div class="form-row margins-8px w-80 mt-4 row">
                        <label for="message" class="col-md-4 control-label"> <strong> Admin Response * </strong></label>
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


                    <div class="row mt-5">
                        <div class="col-6">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteContactMessage">
                                Delete
                            </button>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ url('/messages') }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-large btn-primary">
                                Send Response
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </section>





    <div class="modal fade" id="deleteContactMessage" tabindex="-1" aria-labelledby="deleteArticleLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteArticleLabel">Delete Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this message?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('deleteContactMessage', $message->id)}}" method="POST">
                        @method('post')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
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
