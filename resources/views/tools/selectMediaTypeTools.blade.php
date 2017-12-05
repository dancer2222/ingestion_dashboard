@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    <div class="container">
        {{--<center>--}}
        <div class="row">
            <div class="col-lg-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-lg btn-danger dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Movie
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Active</a>
                        <a class="dropdown-item" href="#">Inactive</a>
                        <a class="dropdown-item" href="#">Fix</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-lg btn-danger dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Books
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Active</a>
                        <a class="dropdown-item" href="#">Inactive</a>
                        <a class="dropdown-item" href="#">Fix</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-lg btn-danger dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        AudioBooks
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Active</a>
                        <a class="dropdown-item" href="#">Inactive</a>
                        <a class="dropdown-item" href="#">Fix</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="btn-group">
                    <button type="button" class="btn btn-lg btn-danger dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        Music
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Active</a>
                        <a class="dropdown-item" href="#">Inactive</a>
                        <a class="dropdown-item" href="#">Fix</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div>
            </div>
        </div>
        {{--</center>--}}
    </div>
@endsection