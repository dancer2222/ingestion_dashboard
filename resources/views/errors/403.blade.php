@extends('errors.layout')

@section('title', '403 Unauthorized action')

@section('content')

<div class="container">

    <div class="row">
        <div class="col-6 mx-auto container-ida text-center p-5">

            <h1 class="text-danger align-middle">403</h1>
            <h2 class="text-danger align-middle">Unauthorized action</h2>

            <a href="{{ url('/') }}" class="btn btn-primary">Home</a>
            <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="btn btn-outline-secondary">Back</a>

        </div>
    </div>

</div>

@endsection