@extends('layouts.app')

@section('content')

    <section class="mt-4 mb-10 pt-4 content container">
        @include('layouts.partials.messages')
        <div class="row">
            <div class="col-12">
                @if($comments->count())
                    <table class="table tbl-hopahop mt-4">
                        <thead>
                        <tr>
                            <th scope="col">DATE</th>
                            <th scope="col">NAME</th>
                            <th scope="col">MESSAGE</th>
                            <th scope="col">ARTICLE</th>
                            <th scope="col">E-MAIL</th>
                            <th scope="col" class="text-center">APPROVED</th>
                            <th scope="col" class="text-center">ACTIONS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($comments as $comment)
                            <tr>
                                <td class="t-bold">{{$comment->updated_at?->format('d-m-Y') ? : ''}}</td>
                                <td class="t-bold">{{$comment->name}}</td>
                                <td class="t-bold">{{$comment->description}}</td>
                                <td class="t-bold">{{$comment->article->title}}</td>
                                <td class="t-bold">{{$comment->email}}</td>
                                <td class="t-bold text-center">
                                    @if($comment->approved == 1)
                                        <p> Approved </p>
                                    @else
                                        <form method="POST" action="{{ route( 'approveComment', $comment->id)}}">
                                            @csrf
                                            <button type="submit" class="btn btn-success"> Approve</button>
                                        </form>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route( 'deleteCommentMessage', $comment->id)}}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"> Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            <div class="pagination-wrapper">
                                {{$comments->links()}}
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center mt-4 pt-4">No comments</p>
                @endif
            </div>
        </div>
    </section>
@endsection
