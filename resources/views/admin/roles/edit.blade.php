@extends('admin.layout')

@section('title', 'Admin - Edit role')

@section('content_admin')

    <div class="col-12">
        {{-- Menu --}}
        <div class="row">
            <div class="col-12 mt-2 mb-2">

                <h3 class="pull-left header-ida">
                    Edit role
                </h3>

            </div>
        </div>

        <div class="row mt-3 mb-3">

            <div class="col-12">

                @if (session('status'))
                    <div class="alert alert-success fade show" role="alert">
                        <strong>User successfully edited</strong>

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


            <form action="{{ ida_route('admin.roles.edit', ['id' => $role->id]) }}" method="post" class="col-12">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" aria-describedby="name" name="name" placeholder="Enter name" value="{{ $role->name }}" required>

                    @if ($errors->has('name'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="display_name">Display name</label>
                    <input type="text" class="form-control" id="display_name" aria-describedby="display_name" name="display_name" placeholder="Display name" value="{{ $role->display_name }}" required>

                    @if ($errors->has('display_name'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('display_name') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Description" required value="{{ $role->description }}">

                    @if ($errors->has('description'))
                        <span class="help-block text-danger">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="permissions">Attach permissions</label>
                    <select id="permissions" name="permissions[]" class="custom-select" multiple>
                        @foreach ($permissions as $permission)
                            <option value="{{ $permission->id }}" {{ $rolePerms && $rolePerms->contains('id', $permission->id) ? 'selected' : '' }}>{{ $permission->display_name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>

@endsection