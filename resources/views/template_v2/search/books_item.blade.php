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
    <b>Authors(id):</b>
    @if($item->authors->count())
        @foreach($item->authors as $author)
            <span class="float-right">[{{ $author->id }}] {{ $author->name }}</span><br>
        @endforeach
    @else
        <span class="float-right color-danger">Not found authors</span>
    @endif
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
<div class="mb-3 bottom">
    <span class="float-left">
        <form method="POST" class="form-group" id="form"
              action="{{ route('reports.parse.index') }}" target="_blank">
            <input type="hidden" id="bucket" name="bucket" value="{{ config('main.links.aws.bucket.books') }}">
            <input type="hidden" id="object" name="object" value="{{ \Ingestion\Search\Normalize::normalizeBucketName($item->licensor->name ?? '') }}/{{ str_replace(["Full_{$item->licensor->name}_", "Delta_{$item->licensor->name}_"], '', $item->qaBatch->title ?? '-') }}">
            <input type="hidden" id="batchTitle" name="batchTitle"
                   value="{{ str_replace(["Full_{$item->licensor->name}_", "Delta_{$item->licensor->name}_"], '', $item->qaBatch->title ?? '-') }}">
            <input type="hidden" id="title" name="title" value="{{ $item->title }}">
            <input type="hidden" id="id" name="id" value="{{ $item->id }}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type="submit" class="btn btn-secondary">Show AWS metadata file <i class="fab fa-aws"></i></button>
        </form>
    </span>
    <span class="float-right">
        <form method="POST" class="form-group" id="form"
              action="{{ route('reports.parse.getMetadataFile') }}">
            <input type="hidden" id="bucket" name="bucket" value="{{ config('main.links.aws.bucket.books') }}">
            <input type="hidden" id="object" name="object" value="{{ \Ingestion\Search\Normalize::normalizeBucketName($item->licensor->name ?? '') }}/{{ str_replace(["Full_{$item->licensor->name}_", "Delta_{$item->licensor->name}_"], '', $item->qaBatch->title ?? '-') }}">
            <input type="hidden" id="batchTitle" name="batchTitle"
                   value="{{ str_replace(["Full_{$item->licensor->name}_", "Delta_{$item->licensor->name}_"], '', $item->qaBatch->title ?? '-') }}">
            <input type="hidden" id="title" name="title" value="{{ $item->title }}">
            <input type="hidden" id="id" name="id" value="{{ $item->id }}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type="submit" class="btn btn-secondary">Download AWS metadata file <i class="fab fa-aws"></i></button>
        </form>
    </span>
</div>
@endsection
