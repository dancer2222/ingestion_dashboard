@extends('template_v2.search.layout.main')

@section('search_primary_info')

{{-- Subtitle --}}
<h4 class="card-title">{{ $item->subtitle }}</h4>

{{-- Cover --}}
<img src="{{ $item->img_url ?? asset('theme_v2/images/background/user-info.jpg') }}"
     class="rounded float-right ml-3 d-block"
     alt="{{ $item->title }}"
     style="max-width: 200px;">

{{-- Description --}}
@include('template_v2.search.including_stack._description_and_Id')

<div class="mb-3 border-bottom">
    <b>UPC:</b> <span class="float-right">{{ $item->upc }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Duration:</b> <span class="float-right">{{ $item->duration }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Release date:</b> <span class="float-right">{{ $item->release_date }}</span>
</div>

{{--General info--}}
@include('template_v2.search.including_stack._general_information')

@endsection
