@extends('layouts.app')

@section('content')

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/carousel/hopahop-shop.jpg" class="d-block w-100" alt="Shop">
        </div>
    </div>
    <section class="content container">
        @if($shops->count())
            <div class="row blog-entries mt-2">
                <div class="col-md-12 main-content">
                    <div class="row">
                        @foreach ($shops as $shop)
                            <div class="col-md-4 mt-5 menu-hoover">
                                <a href="{{$shop->url}}" class="blog-entry element-animate" target="_blank"
                                   rel="noopener noreferrer"
                                   data-animate-effect="fadeIn">
                                    <div class="blog-content-body text-center">
                                        <h2>{{substr(" $shop->title", 0, 25)}}</h2>
                                    </div>
                                    @if( (file_exists( public_path().'/uploads/shop/'.$shop->image)))
                                        <img class="img-thumbnail" src="uploads/shop/{{$shop->image}}"
                                             alt="{{$shop->title}}">
                                    @else
                                        <img class="img-thumbnail" src="uploads/images/default.jpg"
                                             alt="{{$shop->title}}">
                                    @endif
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="pagination-wrapper mt-3">
                            {{$shops->links()}}
                        </div>
                    </div>
                </div>
                @else
                    <p class="text-center mt-4 pt-4">No shop articles</p>
                @endif
            </div>

    </section>
@endsection
