<form action="{{ route('authors.index') }}" method="get">

    <div class="input-group mb-3">
        <input type="text" class="form-control rounded-left mb-2"
               id="needle" name="needle"
               placeholder="Author ID or name" aria-label="needle" aria-describedby="button-addon"
               value="{{ request()->needle }}">

        <div class="input-group-append">
            <button type="submit" class="btn btn-primary pl-4 pr-4 mb-2" id="button-addon">
                Find
            </button>
        </div>
    </div>

    <div class="pull-right">
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="audiobook" name="author_type" class="custom-control-input" value="audio_book"
                {{ !request()->has('author_type') ? 'checked' : request()->get('author_type') == 'audio_book' ? 'checked' : '' }}>
            <label class="custom-control-label" for="audiobook">audiobook</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" id="book" name="author_type" class="custom-control-input" value="book"
                {{ request()->get('author_type') == 'book' ? 'checked' : '' }}>
            <label class="custom-control-label" for="book">book</label>
        </div>
    </div>

</form>