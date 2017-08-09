<!DOCTYPE html>
<html>
<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Dashboard')
    </title>

    <link rel="stylesheet" href="{{ asset('lib/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="">
</head>
<body>

<nav class="navbar navbar-toggleable-md navbar-light bg-faded mb-5">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        @if(Auth::guest())

        <div class="navbar-nav col-12">
            <span class="navbar-text text-center col-12">
                Sign in
            </span>
        </div>

        @else

        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ action('Brightcove\\ContentController@folders') }}">Folders</a>
            </li>
        </ul>

        <form class="form-inline pull-xs-right" method="POST" action="{{ route('logout') }}">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-sm btn-outline-primary">Sign out</button>
        </form>

        @endif

    </div>
</nav>

@yield('content')


<footer class="container-fluid">


</footer>

<script src="{{ asset('lib/jquery/jquery-3.1.1.slim.min.js') }}"></script>
<script src="{{ asset('lib/tether/tether-1.4.0.min.js') }}"></script>
<script src="{{ asset('lib/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('js/main.js') }}"></script>

</body>
</html>