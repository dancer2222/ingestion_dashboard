<div class="container-fluid">
    <div class="row">
        {{--<div class="col-lg-4" align="center">--}}
        {{--<form method="POST" class="form-control-feedback" action="{{ action('SearchController@index') }}">--}}
        {{--<div class="form-group">--}}
        {{--<label for="text"><h3>Search by ID <span--}}
        {{--class="defaultDatabase">{{ config('database.default') }}</span></h3></label>--}}
        {{--<input type="text" class="input-group col-3" id="id" name="id">--}}
        {{--</div>--}}
        {{--<div class="checkbox">--}}
        {{--<label><input type="checkbox" name="option" value="yes" checked>Do not show empty--}}
        {{--values</label>--}}
        {{--</div>--}}
        {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
        {{--<button type="submit" class="btn btn-default">Submit</button>--}}
        {{--</form>--}}
        {{--</div>--}}
        {{--<div class="col-lg-4" align="center">--}}
        {{--<form method="POST" class="form-control-feedback"--}}
        {{--action="{{ action('SearchByTitleController@index') }}">--}}
        {{--<div class="form-group">--}}
        {{--<label for="text"><h3>Search by Title <span--}}
        {{--class="defaultDatabase">{{ config('database.default') }}</span></h3></label>--}}
        {{--<input type="text" class="input-group col-3" id="title" name="title">--}}
        {{--<label for="text">Select a media type</label>--}}
        {{--<br>--}}
        {{--<select class="form-control-sm" id="type" name="type">--}}
        {{--<option name="books">books</option>--}}
        {{--<option name="movies">movies</option>--}}
        {{--<option name="audiobooks">audiobooks</option>--}}
        {{--<option name="albums">albums</option>--}}
        {{--</select>--}}
        {{--</div>--}}
        {{--<input type="hidden" name="_token" value="{{csrf_token()}}">--}}
        {{--<button type="submit" class="btn btn-default">Submit</button>--}}
        {{--</form>--}}
        {{--</div>--}}
        <div class="col-lg-4" align="center" method="get">
            <form id="form_tools" action="{{ route('sel') }}" method="get" class="form-inline">
                <div class="col">
                    <h2>Search by </h2>

                    <select name="type" id="" onchange="$('#form_tools').submit();"
                            class="form-control form-control-lg">
                        <option value="games" {{ request()->has('type') && request()->get('type') == 'games' ? 'selected' : '' }}>
                            Games
                        </option>
                        <option value="audiobooks" {{ request()->has('type') && request()->get('type') == 'audiobooks' ? 'selected' : '' }}>
                            Audiobooks
                        </option>
                        <option value="books" {{ request()->has('type') && request()->get('type') == 'books' ? 'selected' : '' }}>
                            Books
                        </option>
                        <option value="movies" {{ request()->has('type') && request()->get('type') == 'movies' ? 'selected' : '' }}>
                            Movies
                        </option>
                        <option value="games" {{ request()->has('type') && request()->get('type') == 'games' ? 'selected' : '' }}>
                            Games
                        </option>
                        <option value="albums" {{ request()->has('type') && request()->get('type') == 'albums' ? 'selected' : '' }} >
                            Albums
                        </option>
                    </select>
                </div>
            </form>

        </div>
        <div class="col-lg-4" align="center">
            @if(isset($selectedTypes))
                @foreach($selectedTypes as $type)
                    <form method="POST" class="form-control-feedback"
                          action="{{ action($type['controller']) }}">
                        <div class="form-group">
                            <label for="text"><h3>Search by <span style="color: red">{{ $type['variableRequest'] }}</span> <span
                                            class="defaultDatabase">{{ config('database.default') }}</span></h3>
                            </label>
                            @if($type['variableRequest'] == 'id')
                                <input type="text" class="input-group col-3" name="{{ $type['variableRequest'] }}">
                            @else
                                <input type="text" class="input-group col-3" name="input">
                            @endif
                        </div>
                        <input type="hidden" name="type" value="{{request()->get('type')}}">
                        <input type="hidden" name="mediaType" value="{{ $type['variableRequest'] }}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                @endforeach
            @else
                <form method="POST" class="form-control-feedback" action="{{ action('SearchController@index') }}">
                    <div class="form-group">
                        <label for="text"><h3>Search by ID <span
                                        class="defaultDatabase">{{ config('database.default') }}</span></h3></label>
                        <input type="text" class="input-group col-3" id="id" name="id">
                    </div>
                    <div class="checkbox">
                        <label><input type="checkbox" name="option" value="yes" checked>Do not show empty
                            values</label>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

            @endif
        </div>
        <div class="col-lg-4" align="center">
            <form method="POST" class="form-control-feedback"
                  action="{{ action('BatchReportController@index') }}">
                <div class="form-group">
                    <label for="text"><h3>Generate Batch Report <span
                                    class="defaultDatabase">{{ config('database.default') }}</span></h3></label>
                    <input type="text" class="input-group col-3" id="batch_id" name="batch_id">
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
</div>


<br>
<a class="btn btn-info" href="{{ URL::previous() }}">back</a>