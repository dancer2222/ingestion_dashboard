@extends('layouts.main')

@section('title', 'Home')

@section('content')

    <div class="container">
        <div class="row align-items-center welcome-container">
            <div class="col">

                <div class="row">
                    <div class="col text-center">
                        <h3>Search by ID in <span class="defaultDatabase text-primary">{{ config('database.default') }}</span></h3>
                    </div>
                </div>

                <form class="form-inline row justify-content-center" method="post" action="{{ action('SearchController@index') }}">
                    <div class="form-group mx-3">
                        <label for="id" class="sr-only">Password</label>
                        <input type="text" class="form-control" id="id" name="id" placeholder="">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Search
                    </button>
                </form>


            </div>
        </div>
    </div>

@endsection