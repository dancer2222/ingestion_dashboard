<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4" align="center">
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
        </div>
        <div class="col-lg-4" align="center">
            <form method="POST" class="form-control-feedback"
                  action="{{ action('SearchByTitleController@index') }}">
                <div class="form-group">
                    <label for="text"><h3>Search by Title <span
                                    class="defaultDatabase">{{ config('database.default') }}</span></h3></label>
                    <input type="text" class="input-group col-3" id="title" name="title">
                    <label for="text">Select a media type</label>
                    <br>
                    <select class="form-control-sm" id="type" name="type">
                        <option name="books">books</option>
                        <option name="movies">movies</option>
                        <option name="audiobooks">audiobooks</option>
                        <option name="albums">albums</option>
                    </select>
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
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
</div>
<br>
<a href="{{ '/' }}" class="btn btn-info">BACK</a>