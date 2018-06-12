@extends('admin.layout')

@section('title', 'Admin - Edit user')

@section('content_admin')
<div class="row">
    <div class="col-12">

            <div class="card">
                <div class="card-title">
                    <h3 class="pull-left">
                        Edit user: <small class="text-muted">{{ $user->username ?? $user->email }}</small>
                    </h3>
                </div>
                <div class="card-body">
                    {{-- Menu --}}
                    <div class="row">
                        <div class="col-12 mt-2 mb-2 ">

                            <div class="pull-right">
                                <a href="{{ route('admin.users.showCreate') }}" class="btn btn-sm btn-success" title="Add new user">
                                    New user
                                    <i class="fas fa-user-plus"></i>
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="row mt-3 mb-3">

                        <div class="col-12">

                        @if (session('status'))
                            <div class="alert alert-success fade show" role="alert">
                                <strong>User successfully saved</strong>

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if ($errors->has('any'))

                            <div class="alert alert-danger fade show" role="alert">
                                <strong>{{ $errors->first('any') }}</strong>

                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        @endif

                        </div>


                        <form action="{{ route('admin.users.edit', ['id' => $user->id]) }}" method="post" class="col-12">
                            {{ csrf_field() }}

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" aria-describedby="name" name="name" placeholder="Enter name" value="{{ $user->name }}" required>

                                @if ($errors->has('name'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">Email address</label>
                                <input type="email" class="form-control" id="email" aria-describedby="email" name="email" placeholder="Enter email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control user-change-password" id="password" name="password" placeholder="Password" disabled>
                                <a href="#" id="password-changing-enable"><small class="form-text text-info"><u>Click here to change</u></small></a>

                                @if ($errors->has('password'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" disabled>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block text-danger">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="roles">Attach roles</label>
                                <select id="roles" name="roles[]" class="custom-select" multiple>
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>{{ $role->display_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.users.list') }}" class="btn btn-outline-secondary">Cancel</a>
                        </form>
                    </div>
            </div>



    </div>
</div>
@endsection