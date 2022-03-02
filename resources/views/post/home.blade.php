@extends('layouts.app')

@section('content')
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <a href="{{url('/')}}">
                    <img src="images/hopahop-home.jpg" class="d-block w-100" alt="...">
                </a>
            </div>
            <div class="carousel-item">
                <a href="{{route('songs')}}">
                    <img src="images/songs.png" class="d-block w-100" alt="Songs">
                </a>
            </div>
            <div class="carousel-item">
                <a href="{{route('drawings')}}">
                    <img src="images/drawings.jpg" class="d-block w-100" alt="...">
                </a>
            </div>
        </div>
    </div>

    <section class="content container">

        <div class="row blog-entries">
            <div class="col-md-12  main-content">
                <div class="row mt-5 mb-5">
                    <div class="col-md-4">
                        <a href="{{url('/')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="../images/hopahop-home.jpg"
                                 alt="songs">
                            <p href="{{url('/')}}" class="text-center">
                                <button class="btn btn-primary">HOME</button>
                            </p>
                        </a>

                    </div>
                    <div class="col-md-4">
                        <a href="{{route('songs')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="../images/songs.png"
                                 alt="songs">
                            <p href="{{route('songs')}}" class="text-center">
                                <button class="btn btn-primary">SONGS</button>
                            </p>
                        </a>

                    </div>
                    <div class="col-md-4">
                        <a href="{{route('drawings')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="../images/drawings.jpg"
                                 alt="songs">
                            <p href="{{route('drawings')}}" class="text-center">
                                <button class="btn btn-primary">DRAWINGS</button>
                            </p>
                        </a>

                    </div>
                    <div class="col-md-4">
                        <a href="{{route('songs')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="../images/songs.png"
                                 alt="songs">
                            <p href="{{route('drawings')}}" class="text-center">
                                <button class="btn btn-primary">SPORT</button>
                            </p>
                        </a>

                    </div>
                    <div class="col-md-4">
                        <a href="{{route('songs')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="../images/songs.png"
                                 alt="songs">
                            <p href="{{route('drawings')}}" class="text-center">
                                <button class="btn btn-primary">ABOUT</button>
                            </p>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{route('songs')}}" class="blog-entry element-animate"
                           data-animate-effect="fadeIn">
                            <img class="img-thumbnail" src="../images/songs.png"
                                 alt="songs">
                            <p href="{{route('drawings')}}" class="text-center">
                                <button class="btn btn-primary">CONTACT</button>
                            </p>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
