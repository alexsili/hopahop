@extends('layouts.app')

@section('content')
    <section class="mt-4 mb-10 pt-4 content container">
        <h1 class="h2 mb-3">
            Users Management
            <a class="btn btn-primary float-end" href="{{url('/users/create')}}">Add User</a>
        </h1>

        <div class="row">
            <div class="col-md-12">

                @include('layouts.partials.messages')

                @if ($users->count() > 0)

                    <div class="box mt-4">
                        <div class="box-body">
                            <table id="user-list" class="table black-borders bt-0 datatable">
                                <thead>
                                <tr>
                                    <th width="4%" align="center">Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Country</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $j => $user)
                                    <tr>
                                        <td align="center">{{ $j+1 }}</td>
                                        <td>
                                            <a href="{{ url('/users/' . md5($user->id) . '/edit/') }}">{{ $user->fullName ?? 'n/a' }}</a>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ ucfirst($user->roles) }}</td>
                                        <td>{{ $user->country?->name }}</td>
                                        <td>
                                            @if($user->status=='A')
                                                Active
                                            @else
                                                Inactive
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->

                @else
                    <div class="box">
                        <div class="box-body">
                            No users found
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
