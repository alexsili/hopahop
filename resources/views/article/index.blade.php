@extends('layouts.app')

@section('content')

    <section class="mt-4 mb-10 pt-4 content container">
        <div class="row">
            <div class="col-12">
                <h1 class="h4 mb-2">Active Posts
                    <a class="btn btn-primary float-end" href="{{ route('articleCreate') }}">Add Article</a>
                </h1>

            </div>
        </div>

        @include('layouts.partials.messages')

        <div class="row">
            <div class="col-12">
                @if($articles->count())
                    <table class="table tbl-arls mt-4">
                        <thead>
                        <tr>
                            <th scope="col">DATE</th>
                            <th scope="col">CATEGORY</th>
                            <th scope="col">TITLE</th>
                            <th scope="col">DESCRIPTION</th>
                            <th scope="col">IMAGE</th>
                            <th scope="col">VIEWS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($articles as $article)
                            <tr>
                                <td class="t-bold">{{$article->created_at->format('d-m-Y')}}</td>
                                <td class="t-bold">{{$article->category_id}}</td>
                                <td class="t-bold"><a
                                        href="{{route('articleEdit' ,$article->id)}}">{{$article->title}}</a></td>
                                <td class="t-bold">{{$article->description}}</td>
                                <td class="t-bold">{{$article->image}}</td>
                                <td class="t-bold">{{ $article->views }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center mt-4 pt-4">No submissions</p>
                @endif
            </div>
        </div>
    </section>
@endsection
