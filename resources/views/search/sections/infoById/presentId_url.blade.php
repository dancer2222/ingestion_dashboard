<div class="container">
    <form method="POST"
          action="{{ action('SearchController@indexRedirect', ['id_url' => $id_url]) }}">
        <h3>Search by ID <span
                    class="defaultDatabase">{{ config('database.default') }}</span></h3>
        <div class="row">
            <div class="col-sm-3">
                <input class="form-control" type="text" id="id" name="id" value="{{ $id_url }}"><br>
            </div>
            <div class="col-sm-1">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
            <div class="col">
                <input type="checkbox" name="option" value="yes" checked>Don`t show empty values
                <a class="btn btn-info" href="{{ URL::previous() }}" style="float: right">back</a>
            </div>
        </div>
    </form>

</div>
