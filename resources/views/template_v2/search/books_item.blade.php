@extends('template_v2.search.layout.main')

@section('title', "$mediaType - $item->title")

@section('search_primary_info')

{{-- Subtitle --}}
<h4 class="card-title">{{ $item->subtitle }}</h4>

{{-- Cover --}}
<img src="{{ resizer([str_singular($mediaType), $item->data_origin_id]) ?? asset('theme_v2/images/background/user-info.jpg') }}"
     class="rounded float-right ml-3 d-block"
     alt="{{ $item->title }}">

{{-- Description --}}
@include('template_v2.search.including_stack._description_and_Id')

<div class="mb-3 border-bottom">
    <b>Isbn:</b> <span class="float-right">{{ $item->isbn }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Data origin id:</b> <span class="float-right">{{ $item->data_origin_id }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Download_url:</b> <span class="float-right">{{ $item->download_url }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Author_id:</b> <span class="float-right">{{ $item->author_id }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Languages:</b> <span class="float-right">{{ $item->languages ? $item->languages->pluck('name')->implode(', ') : '' }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Data source provider id:</b>
    <span class="float-right">{{ $item->qaBatch->data_source_provider_id ?? '' }} [{{ $item->provider->name ?? '' }}]</span>
</div>

{{--General info--}}
@include('template_v2.search.including_stack._general_information')

@endsection
