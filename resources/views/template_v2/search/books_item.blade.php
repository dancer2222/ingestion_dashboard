@extends('template_v2.layouts.main')

@section('title', "$mediaType - $item->title")

@section('content')

    @include('template_v2.search.search_form')

    @php
        $isActive = $item->status === 'active';
    @endphp

    <div class="row">

        <div class="col-sm-12 col-lg-6 card">
            <div class="card-body">
                {{-- Title & Status switcher--}}
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title">
                            <b>{{ $item->title }}</b>
                        </h5>
                    </div>
                    <div class="col-6 text-right" id="status_panel">
                        {{-- Status switcher --}}
                        <div class="form-check abc-radio abc-radio-success form-check-inline">
                            <input class="form-check-input audiobook_status_change" data-audiobook-id="{{ $item->id }}" type="radio" id="status_active" value="active" name="status" {{ $isActive ? 'checked=""' : '' }}>
                            <label class="form-check-label" for="status_active">Active</label>
                        </div>
                        <div class="form-check abc-radio abc-radio-danger form-check-inline">
                            <input class="form-check-input audiobook_status_change" data-audiobook-id="{{ $item->id }}" type="radio" id="status_inactive" value="inactive" name="status" {{ !$isActive ? 'checked=""' : '' }}>
                            <label class="form-check-label" for="status_inactive">Inactive</label>
                        </div>
                    </div>
                </div>

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
                    <b>ID:</b> <span class="float-right">{{ $item->id }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>Isbn:</b> <span class="float-right">{{ $item->isbn }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>Data origin id:</b> <span class="float-right">{{ $item->data_origin_id }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>Batch id:</b> <span class="float-right">{{ $item->batch_id }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>Date added:</b> <span class="float-right">{{ now()->timestamp($item->date_added)->format('Y-m-d H:i:s') }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>Date published:</b> <span class="float-right">{{ $item->date_published }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>MA release date:</b> <span class="float-right">{{ $item->ma_release_date }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>Download_url:</b> <span class="float-right">{{ $item->download_url }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>Licensor id:</b> <span class="float-right">{{ $item->licensor_id }} [{{ $item->source }}]</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>Author_id</b> <span class="float-right">{{ $item->author_id }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>Language</b> <span class="float-right">{{ $item->language }}</span>
                </div>

                <div class="mb-3 border-bottom">
                    <b>Premium:</b> <span class="float-right">{{ $item->premium }}</span>
                </div>
            </div>
        </div>

    </div>

@endsection