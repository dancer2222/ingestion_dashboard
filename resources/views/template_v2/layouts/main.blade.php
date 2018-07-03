@php
    $templatePrefix = 'theme_v2';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- Tell the browser to be responsive to screen width --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    {{-- Favicon icon --}}
    <link rel="shortcut icon" type="image/png" sizes="16x16" href="{{ asset("$templatePrefix/images/favicon.ico") }}" />

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
    <style>
        tbody tr td {
            font-size: 14px;
            font-family: Poppins,sans-serif;
            color: #2f3d4a;
        }
    </style>
</head>

<body class="fix-header fix-sidebar">

{{-- Preloader - style you can find in spinners.css --}}
<div class="preloader">
    <svg class="circular" viewBox="25 25 50 50">
        <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
    </svg>
</div>

{{-- Main wrapper  --}}
<div id="main-wrapper">

    {{-- Header --}}
    <div class="header">

        @include('template_v2.layouts.header')

    </div>

    {{-- Sidebar --}}
    <div class="left-sidebar">

        @include('template_v2.layouts.sidebar')

    </div>


    {{-- Content --}}
    <div class="page-wrapper">

        {{-- Breadcrumbs --}}
        <div class="row page-titles">

            @include('template_v2.layouts.breadcrumbs')

        </div>

        {{-- Content container --}}
        <div class="container-fluid">

            @include('template_v2.layouts.errors', ['errors' => $errors])
            @include('template_v2.layouts.status')

            @yield('content')

        </div>

        {{-- Footer --}}
        <footer class="footer">

            @include('template_v2.layouts.footer')

        </footer>

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