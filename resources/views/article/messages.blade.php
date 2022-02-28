@extends('layouts.app')

@section('content')

    <section class="mt-4 mb-10 pt-4 content container">
        <div class="row">
            <div class="col-10">
                <h1 class="h4 mb-2">Messages</h1>
            </div>
            <div class="col-2 text-end">
                <a class="btn btn-primary" href="/submissions/{{$submissionId}}/review">BACK</a>
            </div>
        </div>

        @include('layouts.partials.messages')

        <div class="row">
            <div class="col-12">
                @if($messages->count())
                <table class="table tbl-arls mt-4">
                    <thead>
                      <tr>
                        <th scope="col">DATE</th>
                        <th scope="col">FROM</th>
                        <th scope="col">MESSAGE</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)
                            <tr>
                            <td style="width: 7%">{{ $message->created_at->format('d-m-Y') }}</td>
                            <td style="width: 8%">{{ $message->sender }}</td>
                            <td style="width: 75%">{{ $message->content }}</td>
                          </tr>
                        @endforeach
                    </tbody>
                  </table>
                @else
                    <p class="text-center mt-5 pt-4">No messages</p>
                @endif
            </div>
        </div>
    </section>
@endsection
