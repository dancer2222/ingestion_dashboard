@extends('layouts.main')

@section('title', 'Home')

@section('content')

    <div class="container">
        <div class="row align-items-center welcome-container">
            <div class="col">
                <div class="row">
                    <div class="col text-center">
                        <h3>Search by ID in <span
                                    class="defaultDatabase text-primary">{{ config('database.default') }}</span></h3>
                        <form class="form-group  justify-content-center" method="post"
                              action="{{ action('SearchController@index') }}">
                            <div align="center">
                                <label for="id" class="sr-only">Password</label>
                                <input type="text" class="form-control" id="id" name="id" placeholder="">
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="option" value="yes" checked>Do not show empty
                                    values</label>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Search
                            </button>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection