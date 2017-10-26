@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.error')
    @if(isset($id_url) and !isset($type))
        @include('search.sections.selectMediaTypes.presentId_urlNotPresentType')
    @elseif(isset($id_url) and isset($type))
       @include('search.sections.selectMediaTypes.presentId_urlPresentType')
    @else
        @include('search.sections.selectMediaTypes.notPresentId_url')
    @endif

    <br>
    @if(isset($info))
        <div class="container">
            <table class="table table-hover">
                <tr style="background-color: #2ca02c">
                    <td>Field name</td>
                    <td>Data</td>
                </tr>
                <tr>
                    <td>Media Type</td>
                    <td>{{ $mediaTypeTitle }}</td>
                </tr>
                <tr>
                    <td>Image url</td>
                    <td>{{ $imageUrl }} | <img src="{{ $imageUrl }}" style="width:55px; height:80px;"></td>
                </tr>
                @if('yes' === $option)
                    @include('search.sections.selectMediaTypes.presentInfo.optionsYes')
                @else
                    @include('search.sections.selectMediaTypes.presentInfo.optionsNo')
                @endif
                <tr>
                    <td>Geo Restriction</td>
                    <td>{{ $mediaGeoRestrictInfo }}</td>
                </tr>
            </table>
        </div>
        @include('search.sections.links.linksForWatch')
    @endif
@endsection