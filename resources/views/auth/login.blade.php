@php
$templatePrefix = 'theme_v2';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- Tell the browser to be responsive to screen width --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    {{-- Favicon icon --}}
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset("$templatePrefix/images/favicon.png") }}">

    {{-- Title --}}
    <title>@yield('title', env('APP_NAME'))</title>

    {{-- Bootstrap Core CSS --}}
    <link href="{{ asset("$templatePrefix/css/lib/bootstrap/bootstrap.min.css") }}" rel="stylesheet">

    {{-- Additional styles --}}
    @stack('styles')

    {{-- Theme CSS --}}
    <link href="{{ asset("$templatePrefix/css/theme.min.css") }}" rel="stylesheet">

    {{-- Custom CSS --}}


    {{-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --}}
    {{-- WARNING: Respond.js doesn't work if you view the page via file:** --}}
    <!--[if lt IE 9]>
    <script src="https:**oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https:**oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header fix-sidebar">
<!-- Preloader - style you can find in spinners.css -->
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
</div>
<!-- Main wrapper  -->
<div id="main-wrapper">

    <div class="unix-login">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="login-content card">
                        <div class="login-form">
                            <h4>Login</h4>

                            @if ($errors->has('any'))
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                    {{ $errors->first('any') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}

                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label>Email address</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus autocomplete="on">

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label>Password</label>
                                    <input id="password" type="password" class="form-control" name="password" required autocomplete="on">

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                {{--<div class="checkbox">--}}
                                    {{--<label>--}}
                                        {{--<input type="checkbox"> Remember Me--}}
                                    {{--</label>--}}
                                    {{--<label class="pull-right">--}}
                                        {{--<a href="#">Forgotten Password?</a>--}}
                                    {{--</label>--}}

                                {{--</div>--}}
                                <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
                            </form>

                            <hr>

                            <div class="row">
                                <div class="col-lg-3 col-sm-4 col-xs-5">
                                    <a href="{{ route('social.auth', ['provider' => 'google']) }}" class="btn btn-info">
                                        Google+
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- jQuery --}}
<script src="{{ asset("$templatePrefix/js/lib/jquery/jquery.min.js") }}"></script>

{{-- Bootstrap --}}
<script src="{{ asset("$templatePrefix/js/lib/bootstrap/js/popper.min.js") }}"></script>
<script src="{{ asset("$templatePrefix/js/lib/bootstrap/js/bootstrap.min.js") }}"></script>

{{-- Slimscroll --}}
<script src="{{ asset("$templatePrefix/js/jquery.slimscroll.js") }}"></script>

{{-- Menu sidebar --}}
<script src="{{ asset("$templatePrefix/js/sidebarmenu.js") }}"></script>

{{-- Stiky kit --}}
<script src="{{ asset("$templatePrefix/js/lib/sticky-kit-master/dist/sticky-kit.min.js") }}"></script>

{{-- Additional scripts --}}
@stack('scripts')

{{-- Custom js --}}
<script src="{{ asset("$templatePrefix/js/scripts.js") }}"></script>
<script src="{{ asset("$templatePrefix/js/app.js") }}"></script>

</body>

</html>
