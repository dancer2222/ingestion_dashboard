@extends('template_v2.search.layout.main')

@section('search_primary_info')

<h4 class="card-title">{{ $item->subtitle }}</h4>

{{-- Cover --}}
<img src="{{ resizer([str_singular($mediaType), $item->id]) ?: asset('theme_v2/images/background/user-info.jpg') }}"
     class="rounded float-right ml-3 d-block"
     alt="{{ $item->title }}">

{{-- Description --}}
@include('template_v2.search.including_stack._description_and_Id')

<div class="mb-3 border-bottom">
    <b>Brightcove id:</b> <span class="float-right">{{ $item->brightcove->brightcove_id ?? '-' }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Data source provider id:</b>
    <span class="float-right">{{ $item->qaBatch->data_source_provider_id ?? '' }} [{{ $item->provider->get(0)->name ?? '' }}]</span>
</div>

{{--General info--}}
@include('template_v2.search.including_stack._general_information')

<form method="POST" class="form-group" id="form"
      action="{{ route('reports.parse.index') }}" target="_blank">
    <input type="hidden" id="bucket" name="bucket" value="{{ config('main.links.aws.bucket.movies') }}">
    <input type="hidden" id="object" name="object" value="{{ \Ingestion\Search\Normalize::normalizeBucketName($item->licensor->name ?? '') }}/{{ str_replace(["Full_{$item->licensor->name}_", "Delta_{$item->licensor->name}_"], '', $item->qaBatch->title ?? '-') }}">
    <input type="hidden" id="batchTitle" name="batchTitle"
           value="{{ str_replace(["Full_{$item->licensor->name}_", "Delta_{$item->licensor->name}_"], '', $item->qaBatch->title ?? '-') }}">
    <input type="hidden" id="title" name="title" value="{{ $item->title }}">
    <input type="hidden" id="id" name="id" value="{{ $item->id }}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <button type="submit" class="btn btn-info">Display AWS metadata file</button>
</form>

@endsection
