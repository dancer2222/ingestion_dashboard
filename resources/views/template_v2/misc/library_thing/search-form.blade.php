<div class="row">
    <div class="col-12">
        <div class="input-group mb-3">
            <input type="text" class="form-control rounded-left mb-2"
                   id="isbn" name="Isbn"
                   placeholder="Isbn" aria-label="Isbn" aria-describedby="button-addon"
                    value="{{ request()->isbn ?? '' }}">

            <div class="input-group-append">
                <button type="submit" class="btn btn-primary pl-4 pr-4 mb-2" id="button-addon"
                        data-action="{{ route('librarything.ratings.show') }}"
                        onclick="($('#isbn').val()) ? location.replace(this.dataset.action + '/' + $('#isbn').val()) : ''; return false">
                    Find
                </button>
            </div>
        </div>
    </div>
</div>