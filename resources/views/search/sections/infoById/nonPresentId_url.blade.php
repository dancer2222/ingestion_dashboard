<div class="row">
    @if(app()->environment('local'))
    <div class="col-12">
        <div class="card">
            <div class="card-title"></div>
            <div class="card-body">

                <div class="pull-left">
                    {{--<a class="btn btn-info" href="{{ route('search') }}">Search</a>--}}
                </div>

                <div class="pull-right">
                    <h3 class="text-muted">
                        Database connection: <b class="text-warning defaultDatabase">{{ config('database.default') }}</b>
                    </h3>
                </div>

            </div>
        </div>
    </div>
    @endif

    <div class="col-6">

        <div class="card">
            <div class="card-title"></div>
            <div class="card-body">

                <form id="form_tools" action="{{ route('sel') }}" method="get" class="form">
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
        </div>

    </div>

    <div class="col-6">

        <div class="card">
            <div class="card-title"></div>
            <div class="card-body">

                <form method="POST" class="form-control-feedback"
                      action="{{ route('reports.batch_report') }}">
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
                    <button type="submit" class="btn btn-outline-secondary">Submit</button>
                </form>

            </div>
        </div>

    </div>

    <div class="col-6">
        @if(isset($selectedTypes))
            @foreach($selectedTypes as $type)

            <div class="card">
                <div class="card-title">

                    Search by
                    <span style="color: red">{{ $type }}</span>

                </div>
                <div class="card-body">

                    <form method="POST" class="form"
                          action="{{ route('reports.search_by_title') }}">
                        <div class="form-body">

                            <div class="form-group">
                                <input type="text" class="form-control"  name="input" id="{{$type}}">
                            </div>

                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-outline-secondary mt-2">Submit</button>
                        </div>

                        <input type="hidden" name="type" value="{{request()->get('type')}}">
                        <input type="hidden" name="mediaType" value="{{ $type }}">

                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                    </form>

                </div>
            </div>

            @endforeach
        @endif
    </div>
</div>