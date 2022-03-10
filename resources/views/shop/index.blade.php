@extends('layouts.app')

@section('content')

    <section class="mt-4 mb-10 pt-4 content container">
        <div class="row">
            <div class="col-12">
                <h1 class="h4 mb-2">Active Shop Posts
                    <a class="btn btn-primary float-end" href="{{ route('shopCreate') }}">Add Shop Article</a>
                </h1>

            </div>
        </div>

        @include('layouts.partials.messages')

        <div class="row">
            <div class="col-12">
                @if($shops->count())
                    <table class="table tbl-hopahop mt-4">
                        <thead>
                        <tr>
                            <th scope="col">DATE</th>
                            <th scope="col">TITLE</th>
                            <th scope="col">IMAGE</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($shops as $shop)
                            <tr>
                                <td class="t-bold">{{$shop->updated_at->format('d-m-Y')}}</td>
                                <td class="t-bold"><a
                                        href="{{route('shopEdit' ,$shop->id)}}">{{$shop->title}}</a></td>
                                <td>
                                    @if(empty($shop->image))
                                        No image
                                    @else
                                        <img class="img-thumbnail" style="width: 200px; height: 150px;"
                                             src="/uploads/shop/{{ $shop->image }}"
                                             alt="{{ $shop->image}}">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            <div class="pagination-wrapper">
                                {{$shops->links()}}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center mt-4 pt-4">No shop articles</p>
                @endif
            </div>
        </div>
    </section>



@endsection
