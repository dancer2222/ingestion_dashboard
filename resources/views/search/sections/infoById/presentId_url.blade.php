<div class="container">
    <div class="col-xs-8">
        <form method="POST" class="form-control-feedback"
              action="{{ action('SearchController@indexRedirect', ['id_url' => $id_url]) }}">
            <div class="form-group">
                <label for="text"><h3>Search by ID <span
                                class="defaultDatabase">{{ config('database.default') }}</span></h3></label>
                <input type="text" class="input-group col-3" id="id" name="id" value="{{ $id_url }}">
            </div>
            <div class="checkbox">
                <label><input type="checkbox" name="option" value="yes" checked>Do not show empty values</label>
            </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
    <br> <a class="btn btn-info" href="{{ URL::previous() }}">back</a>
</div>
