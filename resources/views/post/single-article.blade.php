@extends('layouts.app')

@section('content')
    @include('layouts.partials.messages')
    <section class="site-section py-lg">
        <div class="container">
            <div class="row blog-entries element-animate">
                <h1 class="mb-4 text-center mt-4">{{$article->title}}</h1>
                <div class="col-md-12  main-content">

                    <div class="ratio ratio-16x9">
                        <iframe src="{{$article->video_url }}" title="{{$article->title}}" allowfullscreen></iframe>
                    </div>
                    <div class="post-content-body">
                        <p class="text-center">{{$article->description}}</p>
                    </div>


                    <div class="pt-5">
                        <h3 class="mb-5">{{$comments->count()}} Comments</h3>
                        <ul class="comment-list">
                            @foreach($comments as $comment)
                                <li class="comment">
                                    <div class="comment-body">
                                        <h3>{{$comment->name}}e</h3>
                                        <p>{{$comment->description}}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <!-- END comment-list -->

                        <div class="comment-form-wrap pt-5">
                            <h3 class="mb-5">Leave a comment</h3>
                            <form action="{{route('addComment', $article)}}" method="POST" class="p-5 bg-light">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Name *</label>
                                    <input type="text"
                                           class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                           name="name">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="message" id="message" cols="30" rows="10"
                                              class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}"></textarea>
                                    @if ($errors->has('message'))
                                        <span class="invalid-feedback">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>
                                <div class="form-group mt-2">
                                    <input type="submit" value="Post Comment" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
