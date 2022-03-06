@extends('layouts.app')

@section('content')

    <section class="mt-4 mb-10 pt-4 content container">
        @include('layouts.partials.messages')

        <div class="row">
            <div class="col-12">
                @if($messages->count())
                    <table class="table tbl-arls mt-4">
                        <thead>
                        <tr>
                            <th scope="col">DATE</th>
                            <th scope="col">NAME</th>
                            <th scope="col">PHONE</th>
                            <th scope="col">E-mail</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($messages as $message)
                            <tr>
                                <td class="t-bold">{{$message->updated_at?->format('d-m-Y') ? : ''}}</td>
                                <td class="t-bold"><a
                                        href="{{route('contactMessagesShow' ,$message->id)}}">{{$message->name}}</a>
                                </td>
                                <td class="t-bold">{{$message->phone}}</td>
                                <td class="t-bold">{{$message->email}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            <div class="pagination-wrapper">
                                {{$messages->links()}}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center mt-4 pt-4">No contact messages</p>
                @endif
            </div>
        </div>
    </section>



@endsection
