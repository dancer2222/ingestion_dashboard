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
<div class="mb-3 border-bottom">
    <b>
        <a data-toggle="collapse" href="#{{$item->id}}_description" role="button" aria-expanded="false" aria-controls="{{$item->id}}_description">
            Description...
        </a>
    </b>
</div>

<div class="collapse mb-3" id="{{$item->id}}_description">
    {{ $item->description }}
</div>

<div class="mb-3 border-bottom">
    <b>ID:</b>
    <span class="float-right">{{ $item->id }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Data origin id:</b>
    <span class="float-right">{{ $item->data_origin_id }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Batch id:</b>
    <span class="float-right">{{ $item->batch_id }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Date added:</b>
    <span class="float-right">{{ now()->timestamp($item->date_added)->format('Y-m-d H:i:s') }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Date published:</b>
    <span class="float-right">{{ $item->date_published }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>MA release date:</b>
    <span class="float-right">{{ $item->ma_release_date }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Street date:</b>
    <span class="float-right">{{ $item->street_date }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Licensor:</b>
    <a href="{{ route('licensors.show', ['id' => $item->licensor_id]) }}">
        <span class="float-right">{{ $item->licensor_id }} - {{ $item->licensor->name ?? '' }}</span>
    </a>
</div>

<div class="mb-3 border-bottom">
    <b>Data source provider id:</b>
    <span class="float-right">{{ $item->data_source_provider_id }} - {{ $item->provider->name ?? '' }}</span>
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
    <b>Premium:</b>
    <span class="float-right">{{ $item->premium }}</span>
</div>


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
            {{ $product->title ? 'title - ' . $product->title : 'isbn - ' . $product->isbn }}
            </a>
        </div>

        <div class="collapse {{ $loop->index === 0 ? 'show' : '' }}" id="collapse_{{ $product->id }}"
             data-parent="#products_accordion" aria-labelledby="product_heading_{{ $product->id }}">
            @foreach($product->getAttributes() as $attributeName => $attributeValue)
            <div class="border-bottom">
                <b>{{ $attributeName }}:</b>
                <span class="float-right">
                {{ $attributeValue }}
                </span>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>

    @endif
</div>
@endpush

@endsection
