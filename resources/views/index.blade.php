@extends('layouts.main')

@section('title', 'Dashboard - Index page')

@section('content')
    <div class="container">
        <div class="col-xs-12">
            <ul class="list-group">
                @foreach($brightcove as $item => $value)
                <a href="{{ action('Brightcove\\ContentController@videos') . "?q={$value['q']}" }}" class="list-group-item list-group-item-action justify-content-between">
                    {{ $item }}
                    <span class="badge badge-default badge-pill">{{ $value['amount'] }}</span>
                </a>
                @endforeach
                <a href="{{ action('SearchController@index')}}" class="list-group-item list-group-item-action justify-content-between" id="a2">Search content</a>
            </ul>
        </div>
    </div>
@endsection