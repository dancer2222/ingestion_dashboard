@extends('template_v2.layouts.main')

@section('title', 'Folders')

@section('content')

<div class="row pb-5">

    <div class="col-12 border-bottom p-2">
        <div class="pull-left">
            <h3 class="text-muted">Folders list</h3>
        </div>
    </div>

    <div class="col-12">
        <div class="row">

            @foreach($folders as $chunk)
                <div class="col-4 mt-4">
                    <div class="list-group">

                    @foreach($chunk as $folder)
                        <a href="{{ app('request')->url() }}/{{ $folder['id'] }}"
                           class="list-group-item d-flex justify-content-between align-items-center list-group-item-action">
                            <span class="text-muted">{{ $folder['name'] }}</span>
                            <span class="badge badge-info badge-pill">{{ $folder['video_count'] }}</span>
                        </a>
                    @endforeach

                    </div>
                </div>
            @endforeach

        </div>
    </div>

</div>

@endsection