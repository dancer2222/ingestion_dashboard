<form action="{{ route('licensors.index') }}" method="get">

    <div class="input-group mb-3">
        <input type="text" class="form-control rounded-left mb-2"
               id="name" name="name"
               placeholder="Licensor name" aria-label="needle" aria-describedby="button-addon"
               value="{{ request()->get('name') }}">

        <div class="input-group-append">
            <button type="submit" class="btn btn-primary pl-4 pr-4 mb-2" id="button-addon">
                Find
            </button>
        </div>
    </div>

    <div class="pull-left">
        <a href="{{ route('licensors.index', ['list' => true]) }}" class="btn btn-outline-dark">View full list</a>

        {{-- Statuses --}}
        <div class="custom-control custom-checkbox custom-control-inline ml-2">
            <input type="checkbox" id="active" name="status[]" class="custom-control-input" value="active"
                    {{ in_array('active', request()->input('status') ?? []) ? 'checked' : '' }}>
            <label class="custom-control-label" for="active">active</label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="inactive" name="status[]" class="custom-control-input" value="inactive"
                    {{ in_array('inactive', request()->input('status') ?? []) ? 'checked' : '' }}>
            <label class="custom-control-label" for="inactive">inactive</label>
        </div>
    </div>

    <div class="pull-right">
        {{-- Media Types --}}
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="audiobooks" name="media_type[]" class="custom-control-input" value="audiobooks"
                {{ in_array('audiobooks', request()->input('media_type') ?? []) ? 'checked' : '' }}>
            <label class="custom-control-label" for="audiobooks">audiobooks</label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="books" name="media_type[]" class="custom-control-input" value="books"
                {{ in_array('books', request()->input('media_type') ?? []) ? 'checked' : '' }}>
            <label class="custom-control-label" for="books">books</label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="movies" name="media_type[]" class="custom-control-input" value="movies"
                {{ in_array('movies', request()->input('media_type') ?? []) ? 'checked' : '' }}>
            <label class="custom-control-label" for="movies">movies</label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="music" name="media_type[]" class="custom-control-input" value="music"
                {{ in_array('music', request()->input('media_type') ?? []) ? 'checked' : '' }}>
            <label class="custom-control-label" for="music">music</label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="games" name="media_type[]" class="custom-control-input" value="games"
                {{ in_array('games', request()->input('media_type') ?? []) ? 'checked' : '' }}>
            <label class="custom-control-label" for="games">games</label>
        </div>
        <div class="custom-control custom-checkbox custom-control-inline">
            <input type="checkbox" id="software" name="media_type[]" class="custom-control-input" value="software"
                {{ in_array('software', request()->input('media_type') ?? []) ? 'checked' : '' }}>
            <label class="custom-control-label" for="software">software</label>
        </div>
    </div>

</form>
