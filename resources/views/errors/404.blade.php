@extends('errors.layout')

@section('title', '404 Page Not Found')

@section('content')

<div class="container">
    <div class="row align-items-center" style="height: 100vh">
        <div class="col card card-outline-warning text-center">
            <div class="card-block">

                <blockquote class="card-blockquote">
                    <h1>Oops!</h1>
                    <h2>404 Not Found</h2>
                    <div class="error-details">
                        Sorry, an error has occured, Requested page not found!<br>
                    </div>

                    <div class="error-actions mt-2">
                        <a href="{{ url('/') }}" class="btn btn-primary" role="button"> Home </a>
                    </div>
                </blockquote>

            </div>
        </div>
    </div>
</div>

@endsection