<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @yield('title', 'Dashboard')
    </title>

    {{-- Libs css --}}
    <link rel="stylesheet" href="{{ asset('lib/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/animate/animate.css') }}">

    {{-- Custom css --}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

<nav class="navbar navbar-toggleable-md navbar-light bg-faded mb-5">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('images/elephant-logo.png') }}" width="50" height="30" alt="">
    </a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @if(!isAuth())

        <div class="navbar-nav col-12">
            <span class="navbar-text text-center col-12">
                Sign in
            </span>
        </div>

        @else

        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdownBrightcove" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                   href="#">Brightcove</a>

                <div class="dropdown-menu" aria-labelledby="dropdownBrightcove">
                    <a class="dropdown-item" href="{{ action('Brightcove\\ContentController@folders') }}">Folders</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a href="{{ action('SearchController@index') }}" class="nav-link">Reports</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ googleUser()->getName() }}
                    <img class="rounded-circle" src="{{ googleUser()->getPhotoUrl() }}" alt="" style="max-height: 30px;">
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item disabled" href="#">Profile <small>coming soon</small></a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" onclick="$('#logout').submit()">Sign out</a>
                </div>
            </li>
        </ul>

        <form id="logout" class="d-none form-inline pull-xs-right" method="POST" action="{{ route('logout') }}">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-sm btn-outline-primary">Sign out</button>
        </form>

        @endif

    </div>
</nav>

@yield('content')


<footer class="container-fluid">

    <div class="col-12 footer-toolbar-container fixed-bottom">
        <span class="db-dropdown-container">
            Current DB:
            <span class="db-connection dropdown dropup">
                <a href="#" class="dropdown-toggle" id="db-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ config('database.default') }}
                </a>

                <div class="dropdown-menu" aria-labelledby="db-dropdown">
                    @foreach (getDbConnections() as $name)
                        @if(str_is('*mysql*', $name))
                            <button class="change-db dropdown-item" type="button">{{ $name }}</button>
                        @endif
                    @endforeach
                </div>
            </span>
        </span>
    </div>

</footer>

{{-- Libs scripts --}}
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{ asset('lib/tether/tether-1.4.0.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('lib/notify-bootstrap/notify.min.js') }}"></script>

{{-- Custom scripts --}}
<script src="{{asset('js/function.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>

</body>
</html>