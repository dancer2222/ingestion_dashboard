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
                    <th style="background-color: #2ca02c">Field name</th>
                    <th style="background-color: #2ca02c">Data</th>
                    <th style="background-color: #2ca02c">For User</th>
                </tr>
                <tr>
                    <td>Media Type</td>
                    <td>{{ $mediaId }}</td>
                    <td>{{ $mediaTypeTitle }}</td>
                </tr>
                <tr>
                    <td>Image url</td>
                    <td>{{ $imageUrl }}</td>
                    <td><img src="{{ $imageUrl }}" style="width:55px; height:80px;"></td>
                </tr>
                @if('yes' === $option)
                    @include('search.sections.selectMediaTypes.presentInfo.optionsYes')
                @else
                    @include('search.sections.selectMediaTypes.presentInfo.optionsNo')
                @endif
                <tr>
                    <td>Geo Restriction</td>
                    <td>
                        <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#country_code">
                            Show Geo Restriction
                        </button>
                    </td>
                    <td>
                        <div id="country_code" class="collapse">
                            {{ $country_code }}
                        </div>
                    </td>

                </tr>
            </table>
        </div>
        @include('search.sections.links.linksForWatch')
    @endif
@endsection