<div class="container">
    <div class="col-xs-8">
        @if(isset($more))
            <form method="POST" class="form-control-feedback"
                  action="{{ action('SearchController@selectRedirect', ['id_url' => $id_url, 'type' => $type]) }}">
                <div class="form-group">
                    <label for="text"><h3>Search by ID <span
                                    class="defaultDatabase">{{ config('database.default') }}</span></h3></label>
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
                    <label><input type="checkbox" name="option" value="yes" checked>Do not show empty
                        values</label>
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
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
    <br> <a href="{{ '/' }}" class="btn btn-info">BACK</a>
</div>