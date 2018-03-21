@extends('admin.layout')

@section('title', 'Admin - Create user')

@section('content_admin')

    <div class="col-12">
        {{-- Menu --}}
        <div class="row">
            <div class="col-12 mt-2 mb-2 ">

                <h3 class="pull-left header-ida">
                    Create a new user
                </h3>

            </div>
        </div>

        <div class="row mt-3 mb-3">

            <div class="col-12">

                @if (session('status'))
                    <div class="alert alert-success fade show" role="alert">
                        <strong>Created successfully created</strong>

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


            <form action="{{ ida_route('admin.users.create') }}" method="post" class="col-12">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" aria-describedby="name" name="name" placeholder="Enter name" value="{{ old('name') }}" required>

                    @if ($errors->has('name'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" aria-describedby="email" name="email" placeholder="Enter email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>

                    @if ($errors->has('password'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>

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
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection