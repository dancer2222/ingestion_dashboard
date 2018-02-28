@extends('admin.layout')

@section('title', 'Admin - Users')

@section('content_admin')

    <div class="col-12">

        {{-- Menu --}}
        <div class="row">
            <div class="col-12 mt-2 mb-2">

                <h3 class="pull-left header-ida">
                    Users list
                </h3>

                <div class="pull-right">
                    <a href="{{ route('admin.users.showCreate') }}" class="btn btn-sm btn-success" title="Add new user">
                        Add new
                        <i class="fas fa-user-plus"></i>
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
                    <th scope="col">Email</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>

                <tbody>

                @foreach($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>

                            <a href="{{ route('admin.users.showEdit', ['user' => $user->id]) }}" title="Edit user">
                                <i class="fas fa-edit text-info"></i>
                            </a>

                            {{-- Delete user --}}
                            <a href="#" title="Delete user" onclick="document.getElementById('form-delete-user-{{ $user->id }}').submit();return false;">
                                <i class="fas fa-user-times text-danger"></i>
                            </a>

                        </td>
                    </tr>

                    {{-- Form Delete user --}}
                    <form action="{{ route('admin.users.delete', ['user' => $user->id]) }}" id="form-delete-user-{{ $user->id }}" method="post" class="hidden">
                        {{ csrf_field() }}
                    </form>
                @endforeach

                </tbody>

            </table>
        </div>

    </div>

@endsection