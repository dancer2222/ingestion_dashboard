@extends('template_v2.layouts.main')

@section('content')

<div class="row">

    {{-- Admin Sidebar --}}
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <ul class="nav nav-pills nav-fill">
                    {{--Users--}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(2) == 'users' ? 'active' : '' }}" href="{{ route('admin.users.list') }}">
                            Users
                        </a>
                    </li>

                    {{--Roles--}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(2) == 'roles' ? 'active' : '' }}" href="{{ route('admin.roles.list') }}">
                            Roles
                        </a>
                    </li>

                    {{--Permissions--}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->segment(2) == 'permissions' ? 'active' : '' }}" href="{{ route('admin.permissions.list') }}">
                            Permissions
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>

</div>

{{-- Admin Content --}}
@yield('content_admin')

@endsection