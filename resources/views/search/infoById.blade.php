@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @if(Session::has('message'))
        <div class="alert alert-danger">
            {{  Session::get('message') }}
        </div>
    @endif
    @if(isset($message))
        <div class="alert alert-danger">
            {{ $message }}
        </div>
    @endif

    @if(isset($id_url))
        <div class="container">

            <div class="col-xs-8">
                <form method="POST" class="form-control-feedback" action="{{ action('SearchController@indexRedirect', ['id_url' => $id_url]) }}">
                    <div class="form-group">
                        <label for="text"><h3>Search by ID <span class="defaultDatabase">{{ config('database.default') }}</span></h3></label>
                        <input type="text" class="input-group col-3" id="id" name="id" value="{{ $id_url }}">
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
    @else
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6" align="center">
                <form method="POST" class="form-control-feedback" action="{{ action('SearchController@index') }}">
                    <div class="form-group">
                        <label for="text"><h3>Search by ID <span class="defaultDatabase">{{ config('database.default') }}</span></h3></label>
                        <input type="text" class="input-group col-3" id="id" name="id">
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="option" value="yes" checked>Do not show empty values</label>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
            <div class="col-lg-6" align="center">
                <form method="POST" class="form-control-feedback" action="{{ action('SearchByTitleController@index') }}">
                    <div class="form-group">
                        <label for="text"><h3>Search by Title <span class="defaultDatabase">{{ config('database.default') }}</span>></h3></label>
                        <input type="text" class="input-group col-3" id="title" name="title">
                        <label for="text">Select a media type</label>
                        <br>
                        <select class="form-control-sm" id="type" name="type">
                            <option name="books">books</option>
                            <option name="movies">movies</option>
                            <option name="audiobooks">audiobooks</option>
                        </select>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>



    </div>
    <br>
    <center>
        <a href="{{ '/' }}" class="btn btn-info" >BACK</a>
    </center>
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
                    @if('movies' === $mediaTypeTitle and $batchInfo != null)

                        <tr>
                            <td>Feed</td>
                            <td>
                                {{ $linkShow }}
                                |   <a href="" data-toggle="collapse" data-target="#link">Link to copy</a>
                                <div id="link" class="collapse">
                                    {{ $linkCopy }}
                                    <form method="POST" class="form-group" action="{{ action('ExcelController@index') }}">
                                        <input type="hidden" id="bucket" name="bucket" value="{{ $bucket }}">
                                        <input type="hidden" id="object" name="object" value="{{ $object }}">
                                        <input type="hidden" id="title" name="batchTitle" value="{{ $batchInfo->title }}">
                                        <input type="hidden" id="title" name="title" value="{{ $info['title'] }}">
                                        <input type="hidden" id="id" name="id" value="{{ $info['id'] }}">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <button type="submit" class="btn btn-info">Info by metadata file</button>
                                    </form>
                                </div>

                                <div class="loader" style="display: none;"><p style="font-weight: bold; color: red">Please wait for loading...</p></div>
                                <div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                                    <div class="modal-lg modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body" style="word-wrap: break-word;">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </td>
                        </tr>
                        @elseif('books' === $mediaTypeTitle and $batchInfo != null)
                        <tr>
                            <td>Feed</td>
                            <td>
                                {{ $linkShow }}
                                |   <a href="" data-toggle="collapse" data-target="#link">Link to copy</a>
                                <div id="link" class="collapse">
                                    {{ $linkCopy }}
                                    <form method="POST" class="form-group" id="form" action="{{ action('ExcelController@index') }}">
                                        <input type="hidden" id="bucket" name="bucket" value="{{ $bucket }}">
                                        <input type="hidden" id="object" name="object" value="{{ $object }}">
                                        <input type="hidden" id="batchTitle" name="batchTitle" value="{{ $batchInfo->title }}">
                                        <input type="hidden" id="title" name="title" value="{{ $info['title'] }}">
                                        <input type="hidden" id="id" name="id" value="{{ $info['id'] }}">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <button type="submit" class="btn btn-info">Info by metadata file</button>
                                    </form>
                                </div>

                                <div class="loader" style="display: none;"><p style="font-weight: bold; color: red">Please wait for loading...</p></div>
                                <div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
                                    <div class="modal-lg modal-dialog">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <div class="modal-body" style="word-wrap: break-word;">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </td>
                        </tr>
                    @elseif('audiobooks' === $mediaTypeTitle and $batchInfo != null)
                        <tr>
                            <td>Batch Title</td>
                            <td>{{ $batchInfo->title }}</td>
                        </tr>
                    @endif
                    @if(isset($batchInfo) and $batchInfo != null)
                            <tr>
                                <td>Import date</td>
                                <td>{{ $batchInfo->import_date }}</td>
                            </tr>
                    @endif
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
                                    @elseif($value === 'date_added')
                                        <tr>
                                            <td>Date aded</td>
                                            <td>  {{ date('Y-m-d', $item)}}</td>
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
                            @elseif($value === 'date_added')
                                <tr>
                                    <td>Date aded</td>
                                    <td>  {{ date('Y-m-d', $item)}}</td>
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