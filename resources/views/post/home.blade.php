@extends('layouts.app')

@section('content')

    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="10000">
                <a href="{{url('/')}}">
                    <img src="images/carousel/hopahop-home.jpg" class="d-block w-100" alt="Home">
                </a>
            </div>

            <div class="carousel-item" data-bs-interval="2000">
                <a href="{{route('songs')}}">
                    <img src="images/carousel/hopahop-songs.jpg" class="d-block w-100" alt="Songs">
                </a>
            </div>

            <div class="carousel-item">
                <a href="{{route('drawings')}}">
                    <img src="images/carousel/hopahop-drawings.jpg" class="d-block w-100" alt="Drawings">
                </a>
            </div>

            <div class="carousel-item">
                <a href="{{route('sport')}}">
                    <img src="images/carousel/hopahop-sport.jpg" class="d-block w-100" alt="Sport">
                </a>
            </div>

            <div class="carousel-item">
                <a href="{{route('about')}}">
                    <img src="images/carousel/hopahop-about.jpg" class="d-block w-100" alt="About">
                </a>
            </div>

            <div class="carousel-item">
                <a href="{{route('contact')}}">
                    <img src="images/carousel/hopahop-contact.jpg" class="d-block w-100" alt="Contact">
                </a>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <section class="content container">

        <div class="row blog-entries">
            <div class="col-md-12  main-content">
                <div class="row mt-5 mb-5">
                    <div class="col-md-4">
                        <a href="{{url('/')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="images/carousel/hopahop-home.jpg"
                                 alt="songs">
                            <p href="{{url('/')}}" class="text-center mt-2">
                                <button class="btn btn-primary">HOME</button>
                            </p>
                        </a>

                    </div>
                    <div class="col-md-4">
                        <a href="{{route('songs')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="images/carousel/hopahop-songs.jpg"
                                 alt="songs">
                            <p href="{{route('songs')}}" class="text-center mt-2">
                                <button class="btn btn-primary">SONGS</button>
                            </p>
                        </a>

                    </div>
                    <div class="col-md-4">
                        <a href="{{route('drawings')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="images/carousel/hopahop-drawings.jpg"
                                 alt="songs">
                            <p href="{{route('drawings')}}" class="text-center mt-2">
                                <button class="btn btn-primary">DRAWINGS</button>
                            </p>
                        </a>

                    </div>
                    <div class="col-md-4">
                        <a href="{{route('sport')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="images/carousel/hopahop-sport.jpg"
                                 alt="songs">
                            <p href="{{route('sport')}}" class="text-center mt-2">
                                <button class="btn btn-primary">SPORT</button>
                            </p>
                        </a>

                    </div>
                    <div class="col-md-4">
                        <a href="{{route('about')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="images/carousel/hopahop-about.jpg"
                                 alt="songs">
                            <p href="{{route('about')}}" class="text-center mt-2">
                                <button class="btn btn-primary">ABOUT</button>
                            </p>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{route('songs')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="images/carousel/hopahop-contact.jpg"
                                 alt="songs">
                            <p href="{{route('drawings')}}" class="text-center mt-2">
                                <button class="btn btn-primary">CONTACT</button>
                            </p>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
