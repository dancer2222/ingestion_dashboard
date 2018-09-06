<div class="row">
    <form action="{{ route('ratings.index', request()->content_type) }}" method="get" class="col-12">
        <div class="input-group mb-3">
            <input type="text" class="form-control rounded-left mb-2"
                   id="needle" name="needle"
                   placeholder="ID or title" aria-label="needle" aria-describedby="button-addon"
                    value="{{ request()->needle ?? '' }}">

            <div class="input-group-append">
                <button type="submit" class="btn btn-primary pl-4 pr-4 mb-2" id="button-addon">
                    Find
                </button>
            </div>
        </div>
    </form>
</div>
