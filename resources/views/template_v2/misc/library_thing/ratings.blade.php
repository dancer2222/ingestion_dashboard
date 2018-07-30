@extends('template_v2.layouts.main')

@section('title', 'Librarything - Ratings')

@section('content')

    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-title">
                    @include('template_v2.misc.library_thing.search-form')
                </div>

                @isset($rating)
                <div class="card-body">
                    <div>ISBN: {{ request()->isbn }}</div>
                    <div>Average rating: {{ $rating }}</div>
                </div>
                @endisset

            </div>
        </div>

    </div>

@endsection
