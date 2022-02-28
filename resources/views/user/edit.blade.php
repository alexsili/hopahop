@extends('layouts.app')

@section('topcss')
    <style type="text/css">
        .validation-error .select2-container--default .select2-selection--single {
            border: 1px solid red;
        }
    </style>
@endsection

@section('content')

    <section class="mt-4 pt-4 mb-10 content container">
        <h1 class="h2 mb-3">
            Users Management &raquo; Edit user
        </h1>

        <div class="row">
            <div class="col-12 col-md-12">
                @include('layouts.partials.messages')
            </div>
        </div>

        <form method="post" action="{{ route('users.update', $user->id) }}">
            @method('put')
            @csrf
            <div class="row mt-3">
                <div class="col-12 col-md-6">

                    <div class="row mb-3">
                        <label for="first_name" class="col-12 col-md-4 control-label">First Name</label>

                        <div class="col-12 col-md-6">
                            <input id="first_name" type="text"
                                   class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                   name="first_name" value="{{ $user->first_name }}" required_>

                            @if ($errors->has('first_name'))
                                <span class="invalid-feedback">{{ $errors->first('first_name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="last_name" class="col-12 col-md-4 control-label">Last Name</label>

                        <div class="col-12 col-md-6">
                            <input id="last_name" type="text"
                                   class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                   name="last_name" value="{{ $user->last_name }}" required_>

                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback">{{ $errors->first('last_name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-12 col-md-4 control-label">E-Mail Address</label>

                        <div class="col-12 col-md-6">
                            <input id="email" type="email"
                                   class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                   name="email" value="{{ $user->email }}" required_>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="country" class="col-md-4 col-form-label">{{ __('Country') }}</label>

                        <div class="col-md-6">
                            <select class="form-select @error('country') is-invalid @enderror select2" name="country"
                                    id="country" required>
                                <option value="{{$user->country_id}}">{{$user->country->name}}</option>
                                @foreach($countries as $key => $name)
                                    <option value="{{$key}}">{{$name}}</option>
                                @endforeach
                            </select>
                            @error('country')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-12 col-md-4 control-label">Password</label>

                        <div class="col-12 col-md-6">
                            <input id="password" type="password"
                                   class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                   name="password" autocomplete="false" required_>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password-confirm" class="col-12 col-md-4 control-label">Confirm
                            Password</label>

                        <div class="col-12 col-md-6">
                            <input id="password-confirm" type="password" class="form-control"
                                   name="password_confirmation" required_>
                        </div>
                    </div>

                    <div class="row mb-3 @if ($errors->has('status')) has-error @endif">
                        <label class="col-sm-4 control-label" for="inputName">Status</label>
                        <div class="col-sm-8">
                            <div class="radio">
                                <input type="radio" name="status" id="status-active" value="A"
                                       @if( $user->status == 'A') checked="checked" @endif
                                <label for="status-active"> &nbsp; Active</label>
                                &nbsp;&nbsp;&nbsp;
                                <input type="radio" name="status" id="status-inactive" value="I"
                                       @if( $user->status == 'I') checked="checked" @endif
                                <label for="status-inactive"> &nbsp;Inactive</label>
                            </div>
                            @if ($errors->has('status')) <p
                                class="invalid-feedback">{{ $errors->first('status') }}</p> @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <h6><strong>User Type</strong></h6>
                        <div class="form-group row @if ($errors->has('user_type')) validation-error @endif">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-check text-start">
                                            <input class="form-check-input " type="checkbox" value="admin"
                                                   name="userTypeAdmin" id="userTypeAdmin"
                                                   @if($user->isAdmin()) checked @endif
                                            <label class="form-check-label" for="userTypeAdmin">Admin</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check text-start">
                                            <input class="form-check-input r" type="checkbox" value="moderator"
                                                   name="userTypeModerator" id="userTypeModerator"
                                                   @if($user->isModerator()) checked @endif
                                            <label class="form-check-label" for="userTypeModerator">Moderator</label>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-check text-start">
                                            <input class="form-check-input non-editor" type="checkbox" value="usual"
                                                   name="userTypeUsual" id="userTypeUsual"
                                                   @if($user->isUsual()) checked @endif
                                            <label class="form-check-label" for="userTypeUsual">Usual</label>
                                        </div>
                                    </div>

                                    @if($errors->has('userTypeAdmin') || $errors->has('userTypeModerator') || $errors->has('userTypeUsual'))
                                        <span class="text-danger" role="alert" style="font-size: 14px;">Please select one option from above fields.</span>
                                    @endif
                                </div>
                                @if ($errors->has('user_type')) <p
                                    class="invalid-feedback">{{ $errors->first('user_type') }}</p> @endif
                            </div>
                        </div>


                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-6">
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#deleteUserModal">
                        Delete
                    </button>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ url('/users') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-large btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete User {{$user->fullName}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are sure you want to delete the user {{$user->fullName}} ?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('users.destroy', md5($user->id))}}" method="POST">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger" style="width: 120px;">Delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>



@endsection
@section('endjs')
    <script>
        $(document).ready(function () {
            $('select').select2({});
        });
    </script>
@endsection
