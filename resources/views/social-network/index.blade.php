@extends('layouts.app')

@section('content')

    <section class="mt-4 mb-10 pt-4 content container">
        <div class="row">
            <div class="col-12">
                <h1 class="h4 mb-2">Social Networks
                    <a class="btn btn-primary float-end" href="{{ route('SocialNetworkCreate') }}">Add Social Network</a>
                </h1>

            </div>
        </div>

        @include('layouts.partials.messages')

        <div class="row">
            <div class="col-12">
                @if($socialNetworks->count())
                    <table class="table tbl-hopahop mt-4">
                        <thead>
                        <tr>
                            <th scope="col">DATE</th>
                            <th scope="col">NAME</th>
                            <th scope="col">URL</th>
                            <th scope="col">CATEGORY</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($socialNetworks as $socialNetwork)
                            <tr>
                                <td class="t-bold">{{$socialNetwork->updated_at->format('d-m-Y')}}</td>
                                <td class="t-bold"><a href="{{route('SocialNetworkEdit' ,$socialNetwork->id)}}">{{$socialNetwork->name ? : "-"}}</a></td>
                                <td class="t-bold">{{$socialNetwork->url}}</td>
                                <td class="t-bold">{{$socialNetwork->category->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            <div class="pagination-wrapper">
                                {{$socialNetworks->links()}}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center mt-4 pt-4">No Social Network</p>
                @endif
            </div>
        </div>
    </section>

@endsection
