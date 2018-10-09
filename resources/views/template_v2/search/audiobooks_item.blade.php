@extends('template_v2.search.layout.main')

@section('search_primary_info')

{{-- Subtitle --}}
<h4 class="card-title">{{ $item->subtitle }}</h4>

{{-- Cover --}}
<img src="{{ resizer([str_singular($mediaType), $item->provider->name, $item->data_origin_id]) ?: asset('theme_v2/images/background/user-info.jpg') }}"
     class="rounded float-right ml-3 d-block"
     alt="{{ $item->title }}">

{{-- Description --}}
@include('template_v2.search.including_stack._description_and_Id')

<div class="mb-3 border-bottom">
    <b>Data origin id:</b>
    <span class="float-right">{{ $item->data_origin_id }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Street date:</b>
    <span class="float-right">{{ $item->street_date }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Sample url:</b>
    <a href="{{ $item->sample_url }}" target="_blank" class="float-right">open in a new window</a>
</div>

<div class="mb-3 border-bottom">
    <b>Runtime:</b>
    <span class="float-right">{{ $item->runtime }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Size (bytes):</b>
    <span class="float-right">{{ $item->size_in_bytes }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Grade level:</b>
    <span class="float-right">{{ $item->grade_level }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Data source provider id:</b>
    <span class="float-right">{{ $item->qaBatch->data_source_provider_id ?? '' }} [{{ $item->provider->name ?? '' }}]</span>
</div>

{{--General info--}}
@include('template_v2.search.including_stack._general_information')

@push('search_nav_items')
<li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#products" role="tab" aria-selected="false">
        <span class="hidden-sm-up"><i class="ti-home"></i></span>
        <span class="hidden-xs-down">Products</span>
    </a>
</li>
@endpush

@push('search_nav_items_content')
<div class="tab-pane" id="products" role="tabpanel">
    @if($item->products->count())

    <div class="mt-2" id="products_accordion">
        @foreach($item->products as $product)
        <div id="product_heading_{{ $product->id }}" class="mb-1">
            <a class="btn btn-primary {{ $loop->index > 1 ? 'collapsed' : '' }}"
                data-toggle="collapse" href="#collapse_{{ $product->id }}" role="button"
                aria-expanded="true" aria-controls="collapse_{{ $product->id }}">
                {{ $product->title ? 'title - ' . $product->title : 'isbn - ' . $product->isbn .'|'. $product->pivot->subscription_type}}
            </a>
        </div>

        <div class="collapse {{ $loop->index === 0 ? 'show' : '' }}" id="collapse_{{ $product->id }}"
             data-parent="#products_accordion" aria-labelledby="product_heading_{{ $product->id }}">
            <div class="border-bottom">
                <b>id:</b>
                <span class="float-right">
                {{ $product->id }}
                </span>
            </div>

            <div class="border-bottom">
                <b>data_source_provider_id:</b>
                <span class="float-right">
                {{ $product->data_source_provider_id }}
                </span>
            </div>

            <div class="border-bottom">
                <b>title:</b>
                <span class="float-right">
                {{ $product->title }}
                </span>
            </div>

            <div class="border-bottom">
                <b>isbn:</b>
                <span class="float-right">
                {{ $product->isbn }}
                </span>
            </div>

            <div class="border-bottom">
                <b>modified_date:</b>
                <span class="float-right">
                {{ $product->modified_date }}
                </span>
            </div>

            <div class="border-bottom">
                <b>price:</b>
                <span class="float-right">
                {{ $product->price }}
                </span>
            </div>

            <div class="border-bottom">
                <b>sale_start_date:</b>
                <span class="float-right">
                {{ $product->sale_start_date }}
                </span>
            </div>

            <div class="border-bottom">
                <b>sale_end_date:</b>
                <span class="float-right">
                {{ $product->sale_end_date }}
                </span>
            </div>

            <div class="border-bottom">
                <b>modified_date:</b>
                <span class="float-right">
                {{ $product->modified_date }}
                </span>
            </div>

            <div class="border-bottom">
                <b>active_date:</b>
                <span class="float-right">
                {{ $product->active_date }}
                </span>
            </div>

            <div class="border-bottom">
                <b>inactive_date:</b>
                <span class="float-right">
                {{ $product->inactive_date }}
                </span>
            </div>

            <div class="border-bottom">
                <b>currency:</b>
                <span class="float-right">
                {{ $product->currency }}
                </span>
            </div>

            <div class="border-bottom">
                <b>status:</b>
                <span class="float-right">
                {{ $product->status }}
                </span>
            </div>
        </div>
        @endforeach
    </div>

    @endif
</div>
@endpush

@endsection
