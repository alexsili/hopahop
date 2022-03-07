@extends('layouts.app')

@section('content')
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/carousel/hopahop-songs.jpg" class="d-block w-100" alt="Songs">
        </div>
    </div>
    <section class="content container">
        @if($articles->count())
            <div class="row blog-entries mt-2">
                <div class="col-md-12 main-content">
                    <div class="row">
                        @foreach ($articles as $article)
                            <div class="col-md-4 mt-4 menu-hoover">
                                <a href="{{route('singleArticle', $article->id)}}" class="blog-entry element-animate"
                                   data-animate-effect="fadeIn">
                                    <div class="blog-content-body text-center">
                                        <h2>{{substr(" $article->title", 0, 25)}}</h2>
                                    </div>
                                    <img class="img-thumbnail" src="uploads/images/{{$article->image}}"
                                         alt="{{$article->title}}">
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
