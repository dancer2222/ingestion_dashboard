@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-danger">
            {{  Session::get('message') }}
        </div>
    @endif
    @if(isset($id_url) and !isset($type))
            <div class="container">
                <div class="col-xs-8">
                    @if(isset($more))
                        <form method="POST" class="form-control-feedback" action="{{ action('SearchController@selectRedirect', ['id_url' => $id_url]) }}">
                            <div class="form-group">
                                <label for="text"><h3>Search by ID {{ config('database.default') }}</h3></label>
                                <input type="text" class="input-group col-3" id="id" name="id" value="{{ $id_url }}">
                                <div class="alert alert-danger">
                                    This id has many media types, select the one you need
                                </div>
                                <label for="text">Select a media type</label>
                                <select class="form-control" id="type" name="type">
                                    @foreach($mediaTypeTitles as $title)
                                        <option value="{{ $title }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="option" value="yes" checked>Do not show empty values</label>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    @else
                        <form method="POST" class="form-control-feedback" action="{{ action('SearchController@index') }}">
                            <div class="form-group">
                                <label for="text"><h3>Search by ID {{ config('database.default') }}</h3></label>
                                <input type="text" class="input-group col-3" id="id" name="id">
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="option" value="yes" checked>Do not show empty values</label>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    @endif
                </div>
                <br> <a href="{{ '/' }}" class="btn btn-info">BACK</a>
            </div>
    @elseif(isset($id_url) and isset($type))
            <div class="container">
                <div class="col-xs-8">
                    @if(isset($more))
                        <form method="POST" class="form-control-feedback" action="{{ action('SearchController@selectRedirect', ['id_url' => $id_url, 'type' => $type]) }}">
                            <div class="form-group">
                                <label for="text"><h3>Search by ID {{ config('database.default') }}</h3></label>
                                <input type="text" class="input-group col-3" id="id" name="id" value="{{ $id_url }}">
                                <div class="alert alert-danger">
                                    This id has many media types
                                </div>
                                <label for="text">Select a media type</label>
                                <select class="form-control" id="type" name="type">
                                    @foreach($mediaTypeTitles as $title)
                                        <option value="{{ $title }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="option" value="yes" checked>Do not show empty values</label>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    @else
                        <form method="POST" class="form-control-feedback" action="{{ action('SearchController@index') }}">
                            <div class="form-group">
                                <label for="text"><h3>Search by ID {{ config('database.default') }}</h3></label>
                                <input type="text" class="input-group col-3" id="id" name="id">
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="option" value="yes" checked>Do not show empty values</label>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    @endif
                </div>
                <br> <a href="{{ '/' }}" class="btn btn-info">BACK</a>
            </div>
    @else
            <div class="container">
                <div class="col-xs-8">
                    @if(isset($more))
                    <form method="POST" class="form-control-feedback" action="{{ action('SearchController@select') }}">
                        <div class="form-group">
                            <label for="text"><h3>Search by ID {{ config('database.default') }}</h3></label>
                            <input type="text" class="input-group col-3" id="id" name="id" value="{{ $id }}">
                                    <div class="alert alert-danger">
                                        This id has many media types
                                    </div>
                                    <label for="text">Select a media type</label>
                                    <select class="form-control" id="type" name="type">
                                        @foreach($mediaTypeTitles as $title)
                                            <option value="{{ $title }}">{{ $title }}</option>
                                        @endforeach
                                    </select>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="option" value="yes" checked>Do not show empty values</label>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                    @else
                        <form method="POST" class="form-control-feedback" action="{{ action('SearchController@indexRedirect') }}">
                            <div class="form-group">
                                <label for="text"><h3>Search by ID {{ config('database.default') }}</h3></label>
                                <input type="text" class="input-group col-3" id="id" name="id">
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox" name="option" value="yes" checked>Do not show empty values</label>
                            </div>
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </form>
                    @endif
                </div>
                <br> <a href="{{ '/' }}" class="btn btn-info">BACK</a>
            </div>
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
                    @elseif($value === 'licensor_id')
                        <tr>
                            <td>Licensor</td>
                            <td>[{{ $item }}]{{ $licensorName }}</td>
                        </tr>
                    @elseif($value === 'data_source_provider_id')
                        <tr>
                            <td>Data source provider</td>
                            <td>[{{ $item }}]{{ $providerName }}</td>
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
                @elseif($value === 'licensor_id')
                    <tr>
                        <td>Licensor</td>
                        <td>[{{ $item }}]{{ $licensorName }}</td>
                    </tr>
                @elseif($value === 'data_source_provider_id')
                    <tr>
                        <td>Data source provider</td>
                        <td>[{{ $item }}]{{ $providerName }}</td>
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
<table class="table table-hover mb-5">
    <tr align="center">
        <td>Watch in playster this {{ $mediaTypeTitle }} - <a href="https://play.playster.com/{{ $mediaTypeTitle }}/{{ $info['id']}}/autumn-with-horses-trudy-nicholson" target="_blank">{{ $info['title'] }}</a></td>
    </tr>
    <tr align="center">
        <td>Watch in QA playster this {{ $mediaTypeTitle }} - <a href="https://qa-playster-v3-3rdparty.playster.com//{{ $mediaTypeTitle }}/{{ $info['id']}}/autumn-with-horses-trudy-nicholson" target="_blank">{{ $info['title'] }}</a></td>
    </tr>
</table>
@endif
@endsection