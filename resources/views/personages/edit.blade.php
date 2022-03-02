@extends('layouts.app')
@section('content')
    <section class="mt-10 mb-10 content container">

        <div class="row mt-4">
            <div class="col-12">

                @include('layouts.partials.messages')

                <form class="form-horizontal" method="POST" action="{{ route('personageUpdate',$personage->id) }}"
                      enctype="multipart/form-data"
                      id="update-personage">
                    @method('put')
                    {{ csrf_field() }}

                    <div class="d-block mt-4">
                        <h4> Edit Personage</h4>
                    </div>

                    <div class="d-block mt-4 pt-2 mr-5 pr-5">

                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <label for="name">Name*</label>
                                <input id="name" type="text"
                                       class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                       name="name" placeholder="Title" value="{{ $personage->name }}"
                                       required_>
                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-row margins-8px w-80 mt-4 row">
                            <div class="col-6">
                                <div class="form-row row">
                                    <label for="cover_letter">Personage Image File* &nbsp;<i
                                            class="fas fa-info-circle small mb-2" data-toggle="tooltip"
                                            title="The maximum size of file must be smaller than 30 MB"></i></label>
                                    <div class="col-12 mt-3 @if(!empty($personage->image)) d-none @endif">
                                        <input type="file" class="form-control" name="image"
                                               placeholder="Image">
                                        @if ($errors->has('image'))
                                            <span class="invalid-feedback d-block">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>
                                    <div
                                        class="form-row margins-8px w-80 @if(empty($personage->image)) d-none @endif coverLetterFile">
                                        <table class="table-borderless ml-2">
                                            <tr>
                                                <td style="width:90%"><a
                                                        href="/uploads/images/{{ $personage->image }}">{{ $personage->image }}</a>
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
                        <div class="input-group mt-4 ">
                            <button type="button" class="btn btn-danger "
                                    data-bs-toggle="modal" data-bs-target="#deleteArticle">
                                Delete Article
                            </button>
                        </div>
                        <div class="input-group mt-4 ">
                            <div class="input-group w-1">
                                <input type="submit" value="Edit Aticle" class="btn btn-primary pull-right">
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
                    <form action="{{ route('deletePersonageImageFile', $personage->id)}}" method="POST">
                        @method('post')
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    Are you sure to delete this article?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('deletePersonage', $personage->id)}}" method="POST">
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
