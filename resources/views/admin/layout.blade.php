@extends('layouts.main')

@section('title', 'Admin area')

@section('content')

<div class="container">
    <div class="row">

        {{-- Admin Sidebar --}}
        <div class="col-3">
            <ul class="nav flex-column nav-pills container-ida">
                {{--Users--}}
                <li class="nav-item">
                    <a class="nav-link rounded-0 {{ request()->segment(2) == 'users' ? 'active' : '' }}" href="{{ route('admin.users.list') }}">
                        Users
                    </a>
                </li>

                {{--Roles--}}
                <li class="nav-item">
                    <a class="nav-link rounded-0 {{ request()->segment(2) == 'roles' ? 'active' : '' }}" href="{{ route('admin.roles.list') }}">
                        Roles
                        <i class="fas fa-exclamation-triangle text-danger pull-right" title="Dangerous area"></i>
                    </a>
                </li>

                {{--Permissions--}}
                <li class="nav-item">
                    <a class="nav-link rounded-0 {{ request()->segment(2) == 'permissions' ? 'active' : '' }}" href="{{ route('admin.permissions.list') }}">
                        Permissions
                        <i class="fas fa-exclamation-triangle text-danger pull-right" title="Dangerous area"></i>
                    </a>
                </li>
            </ul>
        </div>

        {{-- Admin Content --}}
        <div class="col-9">
            <div class="row container-ida">
                @yield('content_admin')
            </div>
        </div>

    </div>
</div>

@endsection