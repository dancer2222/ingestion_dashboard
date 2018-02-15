@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.errorGreen')
    @include('search.sections.message.error')
    <div class="container col-xs-8">
        @if(isset($products))
            @foreach($products as $product)
                <div class="alert alert-danger">
                    @foreach($product as $value => $a)
                        <p>{{ $value }} - {{ $a }}</p>
                    @endforeach
                </div>
            @endforeach
        @endif
    </div>
@endsection

