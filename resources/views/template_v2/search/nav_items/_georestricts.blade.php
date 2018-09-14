<div class="tab-pane p-20 active show" id="georestricts" role="tabpanel">
    <div class="" id="">
    @foreach($restricts as $restrict)
        <span class="text-{{ in_array($restrict->country_code, ['CA', 'GB', 'ES']) ? 'danger font-weight-bold' : 'secondary' }}">
            {{ $restrict->country_code }}
        </span>
    @endforeach
    </div>
</div>
