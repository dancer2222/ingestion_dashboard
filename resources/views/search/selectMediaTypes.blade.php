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
                @if($mediaTypeTitle == 'books')
                    <tr>
                        <td>Image url in bucket</td>
                        <td>{{ $linkImageInBucket }}</td>
                        @if($response == 1)
                            <td style="color: green">Present in the bucket</td>
                        @else
                            <td style="color: red">Not present in the bucket</td>
                        @endif
                    </tr>
                @elseif($mediaTypeTitle == 'albums')
                    <tr>
                        <button type="button" class="btn btn-warning" data-toggle="collapse" data-target="#music">Show tracks in album</button>

                        <div id="music" class="collapse">
                            <h4>Click to track for more info</h4>
                            <ul class="list-group">
                                @foreach($tracks as $track)
                                    <li class="list-group-item">
                                        <a href="{{ action('TrackController@index', [
                                'id' => $track['id'],
                                'option' => 'yes']) }}" style="color: #b6a338; text-decoration: none; font-weight: bold;"
                                           class="list-group-item list-group-item-action">
                                            <span style="color: #761c19">[id]</span>- {{ $track['id'] }}
                                            |&nbsp;<span style="color: #761c19">[Title]</span>- {{ $track['title'] }}
                                            |&nbsp;<span style="color: #761c19">[Date Added]</span> - {{ $track['date_added'] }}
                                            |&nbsp;<span style="color: #761c19">[Status]</span> - {{ $track['status'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <td>artist Name</td>
                        <td>{{ $artistName }}</td>
                    </tr>
                @endif
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