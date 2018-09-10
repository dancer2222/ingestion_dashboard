<div class="row">
    <div class="card col-12">
        <form action="{{ route('reports.index', $mediaType) }}" method="get" class="form">

            <div class="input-group mb-3">
                <input type="text" class="form-control rounded-left mb-2"
                       id="needle" name="needle"
                       placeholder="..." aria-label="needle" aria-describedby="button-addon"
                       value="{{ request()->needle }}">

                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary pl-4 pr-4 mb-2" id="button-addon">
                        Find
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>