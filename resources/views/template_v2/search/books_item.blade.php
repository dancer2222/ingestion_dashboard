@extends('template_v2.layouts.main')

@section('title', "$mediaType - $item->title")

@section('content')

@include('template_v2.search.search_form')

<div class="row">

    <div class="col-12 card">
        <div class="card-body">

            <div class="row">
                <ul class="list-group col-6">
                    @foreach($item->getAttributes() as $attributeName => $attributeValue)

                    <li class="list-group-item list-group-item-action">
                        @if($attributeName === 'description')
                            <b>
                                <a data-toggle="collapse" href="#{{$item->id}}_{{$attributeName}}" role="button" aria-expanded="false" aria-controls="{{$item->id}}_{{$attributeName}}">
                                    {{ $attributeName }}...
                                </a>
                            </b>

                            <div class="collapse" id="{{$item->id}}_{{$attributeName}}">
                                <hr>
                                {{ $attributeValue }}
                            </div>
                        @else
                            <b>{{ $attributeName }}: </b>
                            <span class="float-right">{{ $attributeValue }}</span>
                        @endif
                    </li>

                    @endforeach
                </ul>
            </div>

        </div>
    </div>

</div>

@endsection
