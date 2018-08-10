@extends('template_v2.layouts.main')

@section('title', 'Librarything - Ratings')

@section('content')

    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-title">
                    @include('template_v2.misc.library_thing.search-form')
                </div>

                <div class="card-body">
                    <div class="row">

                        {{-- Ratings --}}
                        <div class="col-sm-12 col-md-4 mb-5">
                            <p class="font-weight-bold">Rating</p>
                            @isset($rating)
                                <div>ISBN: {{ request()->isbn }}</div>
                                <div>
                                    Average rating: <span class="badge badge-dark font-weight-bold">{{ $rating }}</span>
                                </div>
                            @else
                                <p class="text-danger">Not found</p>
                            @endisset
                        </div>

                        {{-- Book librarything datas --}}
                        <div class="col-sm-12 col-md-4 mb-5">
                            <p class="font-weight-bold">Librarything data</p>
                            @isset($bookLibrarything)
                                <div>Workcode: {{ $bookLibrarything->workcode }}</div>
                                <div>
                                    Link:
                                    <a href="https://www.librarything.com/work/{{ $bookLibrarything->workcode }}" target="_blank">
                                        https://www.librarything.com/work/{{ $bookLibrarything->workcode }}
                                    </a>
                                </div>
                            @else
                                <p class="text-danger">Not found</p>
                            @endisset
                        </div>

                        {{-- Product --}}
                        <div class="col-sm-12 col-md-4 mb-5">
                            <p class="font-weight-bold">Products</p>
                            @isset($products)
                                <div>
                                    Found <span class="badge badge-info font-weight-bold">{{ $products->count() }}</span> products audiobooks with this isbn.
                                </div>
                            @else
                                <p class="text-danger">Not found</p>
                            @endisset
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection
