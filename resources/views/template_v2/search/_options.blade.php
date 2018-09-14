{{-- Status switcher --}}
<div class="form-check abc-radio abc-radio-success form-check-inline {{ !$isDisplay ? 'hidden' : '' }}">
    <input class="form-check-input audiobook_status_change"
           type="radio" id="status_active" value="active" name="status"
           data-media-type="{{ $mediaType }}" data-id="{{ $id }}" {{ $isMediaActive ? 'checked="true"' : '' }}>
    <label class="form-check-label" for="status_active">Active</label>
</div>
<div class="form-check abc-radio abc-radio-danger form-check-inline {{ !$isDisplay ? 'hidden' : '' }}">
    <input class="form-check-input audiobook_status_change"
           type="radio" id="status_inactive" value="inactive" name="status"
           data-media-type="{{ $mediaType }}" data-id="{{ $id }}" {{ !$isMediaActive ? 'checked="true"' : '' }}>
    <label class="form-check-label" for="status_inactive">Inactive</label>
</div>
{{-- END Status switcher --}}
