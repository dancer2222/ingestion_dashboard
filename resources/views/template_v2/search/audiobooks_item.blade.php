@extends('template_v2.layouts.main')

@section('title', "$mediaType - $item->title")

@section('content')

@include('template_v2.search.search_form')

<div class="row">

    <div class="col-6 card">
        <div class="card-body">
            <img class="card-img-top" src="{{ $item->img_url ?? asset('theme_v2/images/background/user-info.jpg') }}" alt="Card image cap">
            <h5 class="card-title">{{ $item->title }}</h5>

            <ul class="list-group list-group-flush">
                <li class="list-group-item list-group-item-action">
                </li>
            </ul>
                @foreach($item->getAttributes() as $attributeName => $attributeValue)


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

@endsection
