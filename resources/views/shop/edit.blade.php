@extends('layouts.app')
@section('content')
    <section class="mt-10 mb-10 content container">

        <div class="row mt-4">
            <div class="col-12">

                @include('layouts.partials.messages')

                <form class="form-horizontal" method="POST" action="{{ route('shopUpdate',$shop->id) }}"
                      enctype="multipart/form-data"
                      id="update-submission">
                    @method('put')
                    {{ csrf_field() }}

                    <div class="d-block mt-4">
                        <h4> Edit Shop Article</h4>
                    </div>

                    <div class="d-block mt-4 pt-2 mr-5 pr-5">

                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="title">Title*</label>
                                <input id="title" type="text"
                                       class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                       name="title" placeholder="Title" value="{{ $shop->title }}"
                                       required_>
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="url">Shop URL</label>
                                <input id="url" type="text"
                                       class="form-control {{ $errors->has('url') ? ' is-invalid' : '' }}"
                                       name="url" placeholder="Shop Url" value="{{$shop->url }}"
                                       required_>
                                @if ($errors->has('url'))
                                    <span class="invalid-feedback">{{ $errors->first('url') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <div class="form-row row">
                                    <label for="image">Image* &nbsp;<i
                                            class="fas fa-info-circle small mb-2" data-toggle="tooltip"
                                            title="The maximum size of file must be smaller than 30 MB"></i></label>
                                    <div class="col-12 mt-3 @if(!empty($shop->image)) d-none @endif">
                                        <input type="file" class="form-control" name="image"
                                               placeholder="Image">
                                        @if ($errors->has('image'))
                                            <span class="invalid-feedback d-block">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                    <div
                                        class="form-row margins-8px w-80 @if(empty($shop->image)) d-none @endif coverLetterFile">
                                        <table class="table-borderless ml-2">
                                            <tr>
                                                <td style="width:90%"><a
                                                        href="/uploads/shop/{{ $shop->image }}">{{ $shop->image }}</a>
                                                </td>
                                                <td style="width:10%">
                                                    <button type="button" class="btn btn-danger btn-rm"
                                                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
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
                                <a href="{{ url('/shop') }}" class="btn btn-outline-secondary">Back</a>
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

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this image?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('deleteShopArticleImage', $shop->id)}}" method="POST">
                        @method('post')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="deleteArticle" tabindex="-1" aria-labelledby="deleteArticleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteArticleLabel">Delete Article</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete this shop article?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <form action="{{ route('deleteShopArticle', $shop->id)}}" method="POST">
                        @method('post')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
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
