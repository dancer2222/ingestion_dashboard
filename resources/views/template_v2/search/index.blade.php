@extends('template_v2.layouts.main')

@section('title', 'Search - ' . ucfirst(request()->mediaType))

@section('content')

    @include('template_v2.search.including_stack._search_form')

    @if(isset($list) && $list)
        @include('template_v2.search.including_stack._list')
    @endif

@endsection