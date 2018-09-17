<div class="tab-pane p-20 active show" id="georestricts" role="tabpanel">
    <b>Active --</b>
    @foreach($restricts->where('status', 'active') as $restrict)
        <span class="text-{{ in_array($restrict->country_code, ['CA', 'GB', 'US']) ? 'danger font-weight-bold' : 'secondary' }}">
        {{ $restrict->country_code }}
    </span>
    @endforeach

    <hr>

    <b>Inactive --</b>
    @foreach($restricts->where('status', 'inactive') as $restrict)
        <span class="text-{{ in_array($restrict->country_code, ['CA', 'GB', 'US']) ? 'danger font-weight-bold' : 'secondary' }}">
        {{ $restrict->country_code }}
    </span>
    @endforeach
</div>
