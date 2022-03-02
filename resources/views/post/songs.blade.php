@extends('layouts.app')

@section('content')

    <div class="carousel-inner">
        <div class="carousel-item active">
            <a href="{{route('songs')}}">
                <img src="images/carousel/hopahop-songs.jpg" class="d-block w-100" alt="Songs">
            </a>
        </div>
    </div>
    <section class="content container">

        <h4 class="text-center mt-5 mb-3">Latest Posts</h4>
        @if($articles->count())
            <div class="row blog-entries">
                <div class="col-md-12  main-content">
                    <div class="row">
                        @foreach ($articles as $article)
                            <div class="col-md-4">
                                <a href="{{route('singleArticle', $article->id)}}" class="blog-entry element-animate"
                                   data-animate-effect="fadeIn">
                                    <img class="img-thumbnail" src="uploads/images/{{$article->image}}"
                                         alt="{{$article->title}}">
                                    <div class="blog-content-body">
                                        <div class="post-meta">
                                            <span class="mr-2">{{$article->updated_at?->format('Y-m-d')}}</span>
                                            <span class="ml-2">
                                                    <span class="fa fa-eye">
                                                    </span>{{$article->views}}</span>
                                            <span class="ml-2"><span class="fa fa-comments"></span> </span>
                                        </div>
                                        <h2>{{$article->title}}</h2>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="pagination-wrapper mt-3">
                            {{$articles->links()}}
                        </div>
                    </div>
                </div>
                @else
                    <p class="text-center mt-4 pt-4">No articles</p>
                @endif
            </div>

    </section>
@endsection
