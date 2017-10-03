@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    <div class="container">
        <div class="col-xs-8">
            <form method="GET" class="form-control-feedback" action="{{ action('SearchController@index') }}">
                <div class="form-group">
                    <label for="text">Search for ID</label>
                    <input type="text" class="input-group col-3" id="id" name="id">
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" name="option" value="yes" checked>Do not show empty values</label>
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
        <br> <a href="{{ '/' }}" class="btn btn-info">BACK</a>
    </div>
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
                    @if('movies' === $mediaTypeTitle)
                        <tr>
                            <td>Feed</td>
                            <td>aws s3 ls s3://playster-content-ingestion/{{ mb_strtolower($licensorName) }}/{{ $batchInfo->title }}
                            |   <a href="" data-toggle="collapse" data-target="#link">Link to copy</a>
                            <p id="link" class="collapse">
                                aws s3 cp s3://layster-content-ingestion/{{ mb_strtolower($licensorName) }}/{{ $batchInfo->title }} ./
                            </p>
                            </td>
                        </tr>
                        @elseif('books' === $mediaTypeTitle)
                        <tr>
                            <td>Feed</td>
                            <td>
                                aws s3 ls s3://playster-book-service-dump/{{ mb_strtolower($licensorName) }}/{{ $batchInfo->title }}
                                 |   <a href="" data-toggle="collapse" data-target="#link">Link to copy</a>
                            <p id="link" class="collapse">
                                aws s3 cp s3://playster-book-service-dump/{{ mb_strtolower($licensorName) }}/{{ $batchInfo->title }} ./
                            </p>
                            </td>
                        </tr>
                    @elseif('audiobooks' === $mediaTypeTitle)
                        <tr>
                            <td>Batch Title</td>
                            <td>{{ $batchInfo->title }}</td>
                        </tr>
                    @endif

                    <tr>
                        <td>Import date</td>
                        <td>{{ $batchInfo->import_date }}</td>
                    </tr>
                    <tr>
                        <td>licensor name</td>
                        <td>{{ $licensorName }}</td>
                    </tr>
                    @if('yes' === $option)
                        @foreach($info as $value => $item)
                                @if(null == $item)

                                @else
                                    @if($value === 'description')
                                        <tr>
                                            <td><a href="" data-toggle="collapse" data-target="#description">{{ $value }}</a><br></td>
                                            <td id="description" class="collapse">
                                                {{ $item }}
                                            </td>
                                        </tr>
                                        @else
                                            <tr>
                                                <td>{{ $value }}</td>
                                                <td>{{ $item }}</td>
                                            </tr>
                                    @endif
                                @endif
                        @endforeach
                    @else
                        @foreach($info as $value => $item)
                                @if($value === 'description')
                                    <tr>
                                        <td><a href="" data-toggle="collapse" data-target="#description">{{ $value }}</a><br></td>
                                        <td id="description" class="collapse">
                                            {{ $item }}
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $value }}</td>
                                        <td>{{ $item }}</td>
                                    </tr>
                                @endif

                        @endforeach
                    @endif
                    <tr>
                        <td>Geo Restriction</td>
                        <td>{{ $mediaGeoRestrictInfo }}</td>
                    </tr>
                </table>
            </div>
        <table class="table table-hover">
            <tr align="center">
                <td>Watch in playster this {{ $mediaTypeTitle }} - <a href="https://play.playster.com/{{ $mediaTypeTitle }}/{{ $info['id']}}/autumn-with-horses-trudy-nicholson" target="_blank">{{ $info['title'] }}</a></td>
            </tr>
        </table>
    @endif
@endsection