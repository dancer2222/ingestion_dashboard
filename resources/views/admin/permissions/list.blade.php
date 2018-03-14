@extends('admin.layout')

@section('title', 'Admin - Permissions')

@section('content_admin')

    <div class="col-12">

        {{-- Menu --}}
        <div class="row">
            <div class="col-12 mt-2 mb-2">

                <h3 class="pull-left header-ida">
                    Permissions list
                </h3>

                <div class="pull-right">
                    <a href="{{ route('admin.permissions.showCreate') }}" class="btn btn-sm btn-success" title="Add new permission">
                        Add new
                        <i class="fas fa-lock"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <table class="table table-hover col-12">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Display Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>

                <tbody>

                @foreach($permissions as $permission)
                    <tr>
                        <th scope="row">{{ $permission->id }}</th>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->display_name }}</td>
                        <td>{{ $permission->description }}</td>
                        <td>

                            <a href="{{ route('admin.permissions.showEdit', ['id' => $permission->id]) }}" title="Edit role">
                                <i class="fas fa-edit text-info"></i>
                            </a>

                            {{-- Delete user --}}
                            <a href="#" title="Delete role" onclick="document.getElementById('form-delete-permission-{{ $permission->id }}').submit();return false;">
                                <i class="fas fa-user-times text-danger"></i>
                            </a>

                        </td>
                    </tr>

                    {{-- Form Delete user --}}
                    <form action="{{ route('admin.permissions.delete', ['id' => $permission->id]) }}" id="form-delete-permission-{{ $permission->id }}" method="post" class="hidden">
                        {{ csrf_field() }}
                    </form>
                @endforeach

                </tbody>

            </table>
        </div>

    </div>

@endsection