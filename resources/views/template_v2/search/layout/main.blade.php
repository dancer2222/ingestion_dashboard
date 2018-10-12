@extends('template_v2.layouts.main')

@section('title', ucfirst($mediaType) . " - $item->title")

@push('styles')
    <link rel="stylesheet" href="{{ asset('theme_v2/css/lib/sweetalert/sweetalert.css') }}">
@endpush

@section('content')

@include('template_v2.search.including_stack._search_form')
<div class="row m-t-15">
    <div class="col-6">

        <b>Show on playster this {{ $mediaType }} - <a
                href="{{ config('main.links.playster.prod') }}{{ $mediaType }}/{{ $item->id}}/{{ $item->title }}"
                target="_blank"> {{ $item->title}}</a></b>
    </div>

    <div class="col-6">
        <b>Show on QA playster this {{ $mediaType }} - <a
                href="{{ config('main.links.playster.qa') }}{{ $mediaType }}/{{ $item->id }}/{{ $item->title }}"
                target="_blank">{{ $item->title }}</a></b>
    </div>
</div>
@php
    $isActive = $item->status === 'active';
    $isInBlacklist = isset($item->blacklist) && $item->blacklist->status == 'active';
@endphp

<div class="row">

    <div class="col-sm-12 col-lg-6">
        <div class="status_border_card card border border-{{ $isActive === true && !$isInBlacklist ? 'success' : 'danger' }}">
            <div class="card-body">

                {{-- Title & Status switcher--}}
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title" data-clipboard='{"float": "right", "value": "{{ $item->title }}"}'>
                            <b>{{ $item->title }}</b>
                        </h5>

                        <span class="badge badge-{{ $isActive && !$isInBlacklist ? 'success' : 'danger' }}">{{ $item->status }}</span>

                    </div>

                    @role(['admin', 'ingester'])
                    <div class="col-6 text-right" id="status_panel">
                        {{-- Status switcher --}}

                        @include('template_v2.search.including_stack._options', ['id' => $item->id, 'mediaType' => $mediaType, 'isMediaActive' => $isActive, 'isDisplay' => !$isInBlacklist])

                        @if(in_array($mediaType, ['audiobooks', 'books']))
                        <button class="btn btn-sm btn-outline-dark ld-over-inverse blacklist-btn {{ !$isInBlacklist ? 'hidden' : '' }}" id="blacklist_remove"
                                data-status="inactive" data-id="{{ $item->id }}" data-url="{{ route("content.$mediaType.blacklist") }}">
                            Remove from blacklist
                            <div class="ld ld-ball ld-flip"></div>
                        </button>
                        <button class="btn btn-sm btn-outline-dark ld-over-inverse blacklist-btn {{ $isInBlacklist ? 'hidden' : '' }}" id="blacklist_add"
                                data-status="active" data-id="{{ $item->id }}" data-url="{{ route("content.$mediaType.blacklist") }}">
                            Add to blacklist
                            <div class="ld ld-ball ld-flip"></div>
                        </button>
                        @endif
                    </div>
                    @endrole
                </div>

                {{-- Primary info --}}
                @yield('search_primary_info')

            </div>
        </div>
    </div>

    {{-- Additional info --}}
    <div class="col-sm-12 col-lg-6">
        <div class="card">
            <div class="card-body p-b-0">
                {{-- Nav tabs --}}
                <ul class="nav nav-tabs customtab2" role="tablist">
                    {{-- Common items --}}
                    <li class="nav-item">
                        <a class="nav-link active show" data-toggle="tab" href="#georestricts" role="tab" aria-selected="true">
                            <span class="hidden-sm-up"><i class="ti-user"></i></span>
                            <span class="hidden-xs-down">Geo Restricts</span>
                        </a>
                    </li>

                    <li class="nav-item {{ !$item->statusChanges->count() ? 'hidden' : '' }}">
                        <a class="nav-link" data-toggle="tab" href="#status_info" role="tab" aria-selected="false">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">Status info</span>
                        </a>
                    </li>

                    <li class="nav-item {{ !$item->failedItems->count() ? 'hidden' : '' }}">
                        <a class="nav-link" data-toggle="tab" href="#failed_items" role="tab" aria-selected="false">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">Failed items</span>
                        </a>
                    </li>

                    {{-- Optional items --}}
                    @stack('search_nav_items')
                </ul>

                {{-- Tab panes --}}
                <div class="tab-content">
                    {{-- Common item contents --}}
                    @include('template_v2.search.nav_items._georestricts', ['restricts' => $item->georestricts])
                    @include('template_v2.search.nav_items._status_changes_tracking', ['statusChangesTracking' => $item->statusChanges->reverse()])
                    @include('template_v2.search.nav_items._failed_items', ['failedItems' => $item->failedItems->reverse()])
                    @stack('search_nav_items_content')
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
    <script src="{{ asset('theme_v2/js/lib/sweetalert/sweetalert.min.js') }}"></script>
@endpush