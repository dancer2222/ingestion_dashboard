@php
$contentType = ucfirst(request()->segment(2));
$contentTypeLower = strtolower($contentType);
$contentTypeSingular = str_singular($contentType);
@endphp

@extends('template_v2.layouts.main')

@section('title', 'Ratings - ' . $contentType)

@section('content')

    <div class="row">

        <div class="col-12">
            <div class="card">

                <div class="card-title">
                    @include('template_v2.misc.ratings.search_form')
                </div>

                <div class="card-body">
                    <div class="row">

                        @if(isset($list) && $list)
                        <hr>

                        <div class="col-12 mb-5">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col">{{ $contentTypeSingular }} ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Average Rating - LT</th>
                                    <th scope="col"><i class="fas fa-sliders-h"></i></th>
                                </tr>
                                </thead>

                                @foreach($list as $item)
                                    @include('template_v2.misc.ratings.entity', ['item' => $item])
                                @endforeach
                            </table>
                        </div>


                        @if(isset($list) && $list instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="col-12">
                            {{ $list->links() }}
                        </div>
                        @endisset

                        @endif

                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection
