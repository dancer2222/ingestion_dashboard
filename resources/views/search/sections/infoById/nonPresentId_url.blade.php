<div class="container">
    <div class="row container-ida pt-2 pb-5">

        <div class="col-12 mb-3 pt-2 pb-2 border-bottom">
            <div class="pull-left">
                <a class="btn btn-info" href="{{ URL::previous() }}">Back</a>
            </div>

            @if(app()->environment('local'))
            <div class="pull-right">
                <h3 class="text-muted">
                    Database connection: <b class="text-warning defaultDatabase">{{ config('database.default') }}</b>
                </h3>
            </div>
            @endif
        </div>

        <div class="col-6 mt-2">
            <form id="form_tools" action="{{ ida_route('sel') }}" method="get" class="form">
                <div class="form-group">
                    <h3>
                        <label for="select_type">Select media type</label>
                    </h3>

                    <select name="type" id="select_type" onchange="$('#form_tools').submit();"
                            class="form-control">
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
                        <option value="albums" {{ request()->has('type') && request()->get('type') == 'albums' ? 'selected' : '' }} >
                            Albums
                        </option>
                    </select>
                </div>
            </form>
        </div>

        <div class="col-6 mt-2">
            <form method="POST" class="form-control-feedback"
                  action="{{ ida_route('reports.batch_report') }}">
                <div class="form-group">
                    <h3>
                        <label for="batch_id">
                            Generate Batch Report
                        </label>
                    </h3>

                    <input type="text" class="form-control" id="batch_id" name="batch_id" placeholder="Type batch id">

                    <small id="emailHelp" class="form-text text-info">Search by batch id</small>
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>

        <div class="col-6">
            @if(isset($selectedTypes))
                @foreach($selectedTypes as $type)

                    <hr>

                    <form method="POST" class="form-control-feedback form-control border-0"
                          action="{{ ida_route('reports.search_by_title') }}">
                        <div class="form-group">
                            <h3 class="text-muted">
                                <label for="{{$type}}">
                                    Search by
                                    <span style="color: red">{{ $type }}</span>
                                </label>
                            </h3>
                            <input type="text" class="form-control" name="input" id="{{$type}}">
                        </div>

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="option" value="yes" checked>
                            <label class="custom-control-label" for="customCheck1">Don`t show empty value</label>
                        </div>

                        <input type="hidden" name="type" value="{{request()->get('type')}}">
                        <input type="hidden" name="mediaType" value="{{ $type }}">

                        <input type="hidden" name="_token" value="{{csrf_token()}}">

                        <button type="submit" class="btn btn-default mt-2">Submit</button>
                    </form>
                @endforeach
            @endif
        </div>
    </div>

</div>
