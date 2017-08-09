@extends('layouts.main')

@section('title', 'Folders')

@section('content')

    <div class="container">
        <div class="row">

            @foreach($folders as $chunk)
                <div class="list-group col-4">

                @foreach($chunk as $folder)
                    <a href="{{ app('request')->url() }}/{{ $folder['id'] }}" class="list-group-item list-group-item-action justify-content-between">
                        {{ $folder['name'] }}
                        <span class="badge badge-default badge-pill">{{ $folder['video_count'] }}</span>
                    </a>
                @endforeach

                </div>
            @endforeach

        </div>
    </div>

@endsection