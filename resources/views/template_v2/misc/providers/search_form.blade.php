<form action="{{ route('providers.index') }}" method="get">

    <div class="input-group mb-1">
        <input type="text" class="form-control rounded-left mb-2"
               id="needle" name="needle"
               placeholder="Licensor name or ID" aria-label="needle" aria-describedby="button-addon"
               value="{{ request()->get('needle') }}">

        <div class="input-group-append">
            <button type="submit" class="btn btn-primary pl-4 pr-4 mb-2" id="button-addon">
                Find
            </button>
        </div>
    </div>

    <div class="float-left">
        <a href="{{ route('providers.index', ['list' => true]) }}" class="btn btn-sm btn-outline-dark">View full list</a>
    </div>

    <div class="float-right">
        {{-- Statuses --}}
        {{-- TODO: consider to remove --}}
        {{--<div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">--}}
            {{--@php--}}
                {{--$isActiveChecked = in_array('active', request()->input('status') ?? []) ? 'checked' : '';--}}
                {{--$isInactiveChecked = in_array('inactive', request()->input('status') ?? []) ? 'checked' : '';--}}
            {{--@endphp--}}
            {{--<label class="btn btn-outline-secondary {{ $isActiveChecked ? 'active' : '' }}">--}}
                {{--<input type="checkbox" id="active" name="status[]" class="custom-control-input" value="active"--}}
                        {{--{{ $isActiveChecked }}>--}}
                {{--active--}}
            {{--</label>--}}

            {{--<label class="btn btn-outline-secondary {{ $isInactiveChecked ? 'active' : '' }}">--}}
                {{--<input type="checkbox" id="inactive" name="status[]" class="custom-control-input" value="inactive"--}}
                        {{--{{ $isInactiveChecked }}>--}}
                {{--inactive--}}
            {{--</label>--}}
        {{--</div>--}}

        {{-- Media Types --}}
        @php
            $isAudiobooks = in_array('audiobooks', request()->input('media_type') ?? []);
            $isBooks = in_array('books', request()->input('media_type') ?? []);
            $isMovies = in_array('movies', request()->input('media_type') ?? []);
            $isMusic = in_array('albums', request()->input('media_type') ?? []);
            $isGames = in_array('games', request()->input('media_type') ?? []);
            $isSoftware = in_array('software', request()->input('media_type') ?? []);
        @endphp
        <div class="btn-group btn-group-toggle btn-group-sm" data-toggle="buttons">
            <label class="btn btn-outline-secondary {{ $isAudiobooks ? 'active' : '' }}" for="audiobooks">
                <input type="checkbox" id="audiobooks" name="media_type[]" class="custom-control-input" value="audiobooks"
                        {{ $isAudiobooks ? 'checked' : '' }}>
                audiobooks
            </label>

            <label class="btn btn-outline-secondary {{ $isBooks ? 'active' : '' }}" for="books">
                <input type="checkbox" id="books" name="media_type[]" class="custom-control-input" value="books"
                        {{ $isBooks ? 'checked' : '' }}>
                books
            </label>

            <label class="btn btn-outline-secondary {{ $isMovies ? 'active' : '' }}" for="movies">
                <input type="checkbox" id="movies" name="media_type[]" class="custom-control-input" value="movies"
                        {{ $isMovies ? 'checked' : '' }}>
                movies
            </label>

            <label class="btn btn-outline-secondary {{ $isMusic ? 'active' : '' }}" for="music">
                <input type="checkbox" id="albums" name="media_type[]" class="custom-control-input" value="albums"
                        {{ $isMusic ? 'checked' : '' }}>
                albums
            </label>

            <label class="btn btn-outline-secondary {{ $isGames ? 'active' : '' }}" for="games">
                <input type="checkbox" id="games" name="media_type[]" class="custom-control-input" value="games"
                        {{ $isGames ? 'checked' : '' }}>
                games
            </label>

            <label class="btn btn-outline-secondary {{ $isSoftware ? 'active' : '' }}" for="software">
                <input type="checkbox" id="software" name="media_type[]" class="custom-control-input" value="software"
                        {{ $isSoftware ? 'checked' : '' }}>
                software
            </label>
        </div>
    </div>

</form>
