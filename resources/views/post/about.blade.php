@extends('layouts.app')

@section('content')

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/carousel/hopahop-about.jpg" class="d-block w-100" alt="About">
        </div>
    </div>
    <section class="content container">
        @if($personages->count())
            <div class="row blog-entries mt-2">
                <div class="col-md-12 main-content">
                    <div class="row">
                        @foreach ($personages as $personage)
                            <div class="col-md-6 mt-5 menu-hoover">

                                @if( (file_exists( public_path().'/uploads/images/'.$personage->image)))
                                    <img class="img-thumbnail" src="uploads/personages/{{$personage->image}}"
                                         alt="{{$personage->title}}">
                                @else
                                    <img class="img-thumbnail" src="uploads/images/default.jpg"
                                         alt="{{$personage->title}}">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                    <p class="text-center mt-4 pt-4">No characters added</p>
                @endif
            </div>
    </section>
@endsection
