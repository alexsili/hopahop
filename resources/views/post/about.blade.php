@extends('layouts.app')

@section('content')

    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="images/carousel/hopahop-about.jpg" class="d-block w-100" alt="About">
        </div>
    </div>
    <section class="content container">
        <h4 class="text-center mt-5 mb-3">CHARACTERS</h4>
        @if($articles->count())
            <div class="row blog-entries">
                <div class="col-md-12  main-content">
                    <div class="row">
                        @foreach ($articles as $article)
                            <div class="col-md-6 mt-4">
                                <img class="img-thumbnail" src="uploads/personages/{{$article->image}}"
                                     alt="{{$article->title}}">
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                    <p class="text-center mt-4 pt-4">No personages</p>
                @endif
            </div>

    </section>
@endsection
