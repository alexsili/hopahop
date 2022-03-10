@extends('layouts.app')

@section('content')

    <section class="mt-4 mb-10 pt-4 content container">
        <div class="row">
            <div class="col-12">
                <h1 class="h4 mb-2">Personages
                    <a class="btn btn-primary float-end" href="{{ route('personageCreate') }}">Add Personage</a>
                </h1>

            </div>
        </div>

        @include('layouts.partials.messages')

        <div class="row">
            <div class="col-12">
                @if($personages->count())
                    <table class="table tbl-hopahop mt-4">
                        <thead>
                        <tr>
                            <th scope="col">DATE</th>
                            <th scope="col">NAME</th>
                            <th scope="col">IMAGE</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($personages as $personage)
                            <tr>
                                <td class="t-bold">{{$personage->updated_at->format('d-m-Y')}}</td>
                                <td class="t-bold"><a
                                        href="{{route('personageEdit' ,$personage->id)}}">{{$personage->name}}</a></td>
                                <td><img class="img-thumbnail" style="width: 200px; height: 150px;"
                                         src="/uploads/personages/{{ $personage->image }}"
                                         alt="{{ $personage->image}}">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            <div class="pagination-wrapper">
                                {{$personages->links()}}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center mt-4 pt-4">No Personages</p>
                @endif
            </div>
        </div>
    </section>



@endsection
