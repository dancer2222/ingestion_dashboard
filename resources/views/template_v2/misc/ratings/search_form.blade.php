<div class="row">
    <div class="col-12">
        <div class="input-group mb-3">
            <input type="text" class="form-control rounded-left mb-2"
                   id="id" name="id"
                   placeholder="id" aria-label="id" aria-describedby="button-addon"
                    value="{{ request()->id ?? '' }}">

            <div class="input-group-append">
                <button type="submit" class="btn btn-primary pl-4 pr-4 mb-2" id="button-addon"
                        data-action="{{ route("ratings.show$contentTypeSingular") }}"
                        onclick="($('#id').val()) ? location.replace(this.dataset.action + '/' + $('#id').val()) : ''; return false">
                    Find
                </button>
            </div>
        </div>
    </div>
</div>