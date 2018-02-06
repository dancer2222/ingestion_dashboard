@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.error')
    <br>
    @include('search.sections.infoById.nonPresentId_url')
    <br>
    @if(isset($info))
        <div class="container">
            @include('search.sections.links.linksForWatch')
        </div>
        <br>
        <div class="container">
            <table class="table table-hover">
                <th style="background-color: #2ca02c">
                    Field name
                </th>
                <th style="background-color: #2ca02c">
                    Data
                </th>
                <th style="background-color: #2ca02c">
                    For User
                </th>
                <tr>
                    <td>Media Type</td>
                    <td>{{ $mediaGeoRestrictGetMediaType }}</td>
                    <td>{{ $mediaTypeTitle }}</td>
                </tr>
                <tr>
                    <td>Image url</td>
                    <td>{{ $imageUrl }}</td>
                    <td><img src="{{ $imageUrl }}" style="width:55px; height:80px;"></td>
                </tr>
                @if('movies' === $mediaTypeTitle and $batchInfo != null)
                    @include('search.sections.infoById.presentInfo.moviesPresentBatchInfo')
                @elseif('books' === $mediaTypeTitle and $batchInfo != null)
                    @include('search.sections.infoById.presentInfo.booksPresentBatchInfo')
                @elseif('audiobooks' === $mediaTypeTitle and $batchInfo != null)
                    @include('search.sections.infoById.presentInfo.audiobooksPresentBatchInfo')
                @elseif('albums' === $mediaTypeTitle)
                    @include('search.sections.infoById.albums.albumsInfo')
                @endif
                @if(isset($batchInfo) and $batchInfo != null)
                    @include('search.sections.infoById.presentInfo.presentBatchInfoImportDate')
                @endif
                @if('yes' === $option)
                    @include('search.sections.infoById.presentInfo.optionsYes')
                @else
                    @include('search.sections.infoById.presentInfo.optionsNo')
                @endif
                <tr>
                    <td>Geo Restriction</td>
                    <td>
                        <button type="button" class="btn btn-outline-success" data-toggle="collapse"
                                data-target="#country_code">
                            Show Geo Restriction
                        </button>
                        <div id="country_code" class="collapse">
                            <table class="table table-hover">
                                <tr>
                                    <td>
                                        <b style='color: green'>Active</b> --> @foreach($country_code as $item)
                                            @if($item['status'] == 'active')
                                                @if( in_array($item['country_code'],['US', 'CA', 'GB']))
                                                    <b style='color: red'>{{ $item['country_code'] }}</b>
                                                @else
                                                    {{ $item['country_code'] }}
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <b style='color: green'>Inactive</b> --> @foreach($country_code as $item)
                                            @if($item['status'] == 'inactive')
                                                @if( in_array($item['country_code'],['US', 'CA', 'GB']))
                                                    <b style='color: red'>{{ $item['country_code'] }}</b>
                                                @else
                                                    {{ $item['country_code'] }}
                                                @endif
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endif

@endsection