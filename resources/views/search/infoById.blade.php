@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.error')
    @if(isset($id_url))
        @include('search.sections.infoById.presentId_url')
    @else
        @include('search.sections.infoById.nonPresentId_url')
    @endif

    <br>
    @if(isset($info))
        <div class="container">
            <table class="table table-hover">
                <th style="background-color: #2ca02c">
                    Field name
                </th>
                <th style="background-color: #2ca02c">
                    Data
                </th>
                <tr>
                    <td>Media Type</td>
                    <td>{{ $mediaTypeTitle }}</td>
                </tr>
                <tr>
                    <td>Image url</td>
                    <td>{{ $imageUrl }} | <img src="{{ $imageUrl }}" style="width:55px; height:80px;"></td>
                </tr>
                @if('movies' === $mediaTypeTitle and $batchInfo != null)
                    @include('search.sections.infoById.presentInfo.moviesPresentBatchInfo')
                @elseif('books' === $mediaTypeTitle and $batchInfo != null)
                    @include('search.sections.infoById.presentInfo.booksPresentBatchInfo')
                @elseif('audiobooks' === $mediaTypeTitle and $batchInfo != null)
                    @include('search.sections.infoById.presentInfo.audiobooksPresentBatchInfo')
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
                    <td>{{ $country_code }}</td>
                </tr>
            </table>
        </div>
        @include('search.sections.links.linksForWatch')
    @endif

@endsection