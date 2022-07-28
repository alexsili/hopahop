@extends('layouts.app')
@section('content')
    <section class="mt-10 mb-10 content container">

        <div class="row mt-4">
            <div class="col-12">

                @include('layouts.partials.messages')

                <form class="form-horizontal" method="POST" action="{{ route('SocialNetworkUpdate', $socialNetwork->id) }}"
                      enctype="multipart/form-data"
                      id="update-submission">
                    @method('put')
                    {{ csrf_field() }}

                    <div class="d-block mt-4">
                        <h4> Edit Social Network</h4>
                    </div>

                    <div class="d-block mt-4 pt-2 mr-5 pr-5">

                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="name">Name*</label>
                                <input id="name" type="text"
                                       class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name" placeholder="Name" value="{{ $socialNetwork->name }}"
                                       required_>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="url">Link Video* (embed)</label>
                                <input id="url" type="text"
                                       class="form-control {{ $errors->has('url') ? ' is-invalid' : '' }}"
                                       name="url" placeholder="Url" value="{{$socialNetwork->url }}"
                                       required_>
                                @if ($errors->has('url'))
                                    <span class="invalid-feedback">{{ $errors->first('url') }}</span>
                                @endif
                            </div>
                        </div>


                        <div class="required-fields text-right">
                            * required fields
                        </div>
                        <div class="row mt-5">
                            <div class="col-6">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#deleteArticle">
                                    Delete
                                </button>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ url('/social-network') }}" class="btn btn-outline-secondary">Back</a>
                                <button type="submit" class="btn btn-large btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </section>


    <div class="modal fade" id="deleteArticle" tabindex="-1" aria-labelledby="deleteArticleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteArticleLabel">Delete Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this article?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('deleteSocialNetwork', $socialNetwork->id)}}" method="POST">
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
