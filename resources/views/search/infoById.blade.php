@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.error')
    <br>
    @include('search.sections.infoById.nonPresentId_url')
    <br>
    @if(isset($info))
        <div class="container ">
            @include('search.sections.links.linksForWatch')
        </div>
        <br>
        <div class="container">
            <div class="row container-ida">
                <table class="table table-hover">
                    <tr style="background-color: #2ca02c">
                        <th >
                            Field name
                        </th>
                        <th>
                            Data
                        </th>
                        <th>
                            For User
                        </th>
                    </tr>

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
                    @include('search.sections.infoById.geoRestriction')
                </table>
        </div>
    @endif
@endsection