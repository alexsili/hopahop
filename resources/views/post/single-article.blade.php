@extends('layouts.app')

@section('content')
    <section class="site-section py-lg">
        <div class="container">
            <div class="row blog-entries element-animate mt-4">
                @include('layouts.partials.messages')
                <div class="col-md-12  main-content">
                    <div class="ratio ratio-16x9">
                        <iframe src="{{$article->video_url }}" title="{{$article->title}}" allowfullscreen></iframe>
                    </div>
                    <div class="post-content-body">
                        <h1 class="mb-4 mt-4">{{ $article->title}}</h1>
                        <p style="text-align: justify">{{$article->description}}</p>
                        <p>
                            Subscribe for new videos: <a href="https://www.youtube.com/c/HopaHop?sub_confirmation=1" target="_blank"> https://www.youtube.com/c/HopaHop?sub_confirmation=1 </a>
                            <br>
                            Facebook: <a href="https://www.facebook.com/HopaHop-Nursery-Rhymes-100656955132329" target="_blank"> https://www.facebook.com/HopaHop-Nursery-Rhymes-100656955132329 </a>
                            <br>
                            Twitter: <a href="https://twitter.com/HopaHop9" target="_blank"> https://twitter.com/HopaHop9 </a>
                            <br>
                            TikTok: <a href="https://www.tiktok.com/@hopahop9" target="_blank">https://www.tiktok.com/@hopahop9</a>
                        </p>
                    </div>
                    <div class="pt-5">
                        <h3 class="mb-5">Comments({{$comments->count()}})</h3>
                        <ul class="comment-list">
                            @foreach($comments as $comment)
                                <li class="comment">
                                    <div class="comment-body">
                                        <h3>{{$comment->name}}</h3>
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
                                           name="name" value="{{ old('name')}}">
                                    @if ($errors->has('name'))
                                        <span class="invalid-feedback">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" value="{{old('email')}}"
                                           class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                           name="email">
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea name="message" id="message" cols="30" rows="10"
                                              class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}">{{old('message')}}</textarea>
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
