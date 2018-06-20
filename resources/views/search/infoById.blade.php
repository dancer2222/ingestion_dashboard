@extends('template_v2.layouts.main')

@section('title', 'Search')

@section('content')
<style>
    tbody tr td {
        font-family: Poppins,sans-serif;
        color: #2f3d4a;
    }
</style>
    @include('search.sections.message.errorGreen')

    @if(isset($message))
        @include('search.sections.message.error')
    @endif

    @include('search.sections.infoById.nonPresentId_url')

    @if(isset($info))

        <hr/>

        @include('search.sections.links.linksForWatch')

        <br>

        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-title"></div>
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-hover text-dark">
                                <thead>
                                <tr style="background-color: #2ca02c">
                                    <th>
                                        Field name
                                    </th>
                                    <th>
                                        Data
                                    </th>
                                    <th>
                                        For User
                                    </th>
                                </tr>
                                </thead>

                                <tbody>

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
                                @elseif('movies' === $mediaTypeTitle and isset($brightcove_id))
                                    <tr>
                                        <td>Brightcove_id</td>
                                        <td>{{ $brightcove_id }}</td>
                                        <td></td>
                                    </tr>
                                @elseif('books' === $mediaTypeTitle and $batchInfo != null)
                                    @include('search.sections.infoById.presentInfo.booksPresentBatchInfo')
                                @elseif('audiobooks' === $mediaTypeTitle and $batchInfo != null)
                                    @include('search.sections.infoById.presentInfo.audiobooksPresentBatchInfo')
                                @elseif('albums' === $mediaTypeTitle)
                                    @include('search.sections.infoById.albums.albumsInfo')
                                @endif
                                @include('search.sections.infoById.metadata')
                                @if('yes' === $option)
                                    @include('search.sections.infoById.presentInfo.optionsYes')
                                @else
                                    @include('search.sections.infoById.presentInfo.optionsNo')
                                @endif
                                @include('search.sections.infoById.geoRestriction')

                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    @endif

@endsection