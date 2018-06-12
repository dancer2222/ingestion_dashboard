@extends('template_v2.layouts.main')

@section('title', 'Dashboard - Index page')

@section('content')
    <div class="row">
        <div class="col-12">
            <ul class="list-group">
                @foreach($brightcove as $item => $value)
                <a href="{{ route('brightcove.videos') . "?q={$value['q']}" }}" class="list-group-item list-group-item-action justify-content-between">
                    {{ $item }}
                    <span class="badge badge-dark">{{ $value['amount'] }}</span>
                </a>
                @endforeach
            </ul>
        </div>
    </div>
@endsection