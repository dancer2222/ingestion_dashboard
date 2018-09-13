@extends('template_v2.layouts.main')

@section('title', ucfirst($mediaType) . " - $item->title")

@section('content')

@include('template_v2.search._search_form')

@php
    $isActive = $item->status === 'active';
    $isInBlacklist = (isset($item->blacklist) && $item->blacklist->status == 'active') || !isset($item->blacklist);
@endphp

<div class="row">

    <div class="col-sm-12 col-lg-6">
        <div class="status_border_card card border border-{{ $isActive === true && !$isInBlacklist ? 'success' : 'danger' }}">
            <div class="card-body">

                {{-- Title & Status switcher--}}
                <div class="row">
                    <div class="col-6">
                        <h5 class="card-title" data-clipboard="{float: 'right', value: {{ $item->title }}">
                            <b>{{ $item->title }}</b>
                        </h5>
                    </div>
                    <div class="col-6 text-right" id="status_panel">
                        {{-- Status switcher --}}

                        @include('template_v2.search._options', ['id' => $item->id, 'mediaType' => $mediaType, 'isMediaActive' => $isActive, 'isDisplay' => !$isInBlacklist])

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
                    </div>
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

                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#status_info" role="tab" aria-selected="false">
                            <span class="hidden-sm-up"><i class="ti-email"></i></span>
                            <span class="hidden-xs-down">Status info</span>
                        </a>
                    </li>

                    {{-- Optional items --}}
                    @stack('search_nav_items')
                </ul>

                {{-- Tab panes --}}
                <div class="tab-content">
                    {{-- Common item contents --}}
                    @include('template_v2.search.nav_items._georestricts', ['restricts' => $item->georestricts])
                    @include('template_v2.search.nav_items._status_changes_tracking', ['statusChangesTracking' => $item->statusChanges])

                    @stack('search_nav_items_content')
                </div>
            </div>
        </div>
    </div>

</div>

@endsection