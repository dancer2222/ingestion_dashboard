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
                    @include('template_v2.misc.ratings.search-form')
                </div>

                <div class="card-body">
                    <div class="row">

                        @if(isset($list) || isset($entity))
                        <div class="col-12 mb-5">
                            <table class="table table-hover table-bordered">
                                <thead class="thead-dark text-center">
                                <tr>
                                    <th scope="col">{{ $contentTypeSingular }} ID</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Average Rating</th>
                                    <th scope="col">Total Votes</th>
                                    <th scope="col"><i class="fas fa-sliders-h"></i></th>
                                </tr>
                                </thead>

                                @isset($list)
                                    @foreach($list as $item)
                                        @include('template_v2.misc.ratings.entity', ['item' => $item])
                                    @endforeach
                                @endisset

                                @isset($entity)
                                    @include('template_v2.misc.ratings.entity', ['item' => $entity])
                                @endisset
                            </table>
                        </div>


                        @isset($list)
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
