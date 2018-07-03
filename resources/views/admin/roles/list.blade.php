@extends('admin.layout')

@section('title', 'Admin - Roles')

@section('content_admin')
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">

                {{-- Menu --}}
                <div class="row">
                    <div class="col-12 mt-2 mb-2">

                        <h3 class="pull-left header-ida">
                            Roles list
                        </h3>

                        <div class="pull-right">
                            <a href="{{ route('admin.roles.showCreate') }}" class="btn btn-sm btn-success" title="Add new role">
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

                        @foreach($roles as $role)
                            <tr>
                                <th scope="row">{{ $role->id }}</th>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->description }}</td>
                                <td>

                                    <a href="{{ route('admin.roles.showEdit', ['id' => $role->id]) }}" title="Edit role">
                                        <i class="fas fa-edit text-info"></i>
                                    </a>

                                    {{-- Delete user --}}
                                    <a href="#" title="Delete role" onclick="document.getElementById('form-delete-role-{{ $role->id }}').submit();return false;">
                                        <i class="fas fa-user-times text-danger"></i>
                                    </a>

                                </td>
                            </tr>

                            {{-- Form Delete user --}}
                            <form action="{{ route('admin.roles.delete', ['id' => $role->id]) }}" id="form-delete-role-{{ $role->id }}" method="post" class="hidden">
                                {{ csrf_field() }}
                            </form>
                        @endforeach

                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection