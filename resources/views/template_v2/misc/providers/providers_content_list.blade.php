{{--@php--}}
    {{--$filterIsActive = in_array('active', $statuses);--}}
    {{--$filterIsInactive = in_array('inactive', $statuses);--}}
    {{--$filterTrackingStatusActive = in_array('active', $trackingStatuses);--}}
    {{--$filterTrackingStatusInactive = in_array('inactive', $trackingStatuses);--}}
{{--@endphp--}}

<hr>

{{--<h3>--}}
    {{--Provider--}}

    {{--<a href="{{ route('providers.export.content', ['media_type' => request()->get('media_type'), 'id' => $provider->id]) }}" class="btn btn-outline-info btn-sm float-right" target="_blank">--}}
        {{--Export CSV--}}
    {{--</a>--}}
{{--</h3>--}}

<div class="row">

    <div class="col-md-3">
        <div class="card p-30 card-shadow-hover">
            <div class="media">
                <div class="media-body">
                    <h5 class="mt-0 mb-1">Name: {{ $provider->name }}</h5>
                    <p class="h-4 mt-3">ID: {{ $provider->id }}</p>
                    <p class="h-4">Media type: {{ $mediaType }}</p>
                </div>
                <i class="align-self-center ml-3 fas fa-user f-s-40"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-30 card-shadow-hover">
            <div class="media">
                <div class="media-body">
                    <h5 class="mt-0 mb-1">{{ $providerActiveContent }}</h5>
                    <p class="h-4 mt-3">active {{ $mediaType }}</p>
                </div>
                <i class="align-self-center mr-3 fas fa-smile text-success f-s-40"></i>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-30 card-shadow-hover">
            <div class="media">
                <div class="media-body">
                    <h5 class="mt-0 mb-1">{{ $providerInactiveContent }}</h5>
                    <p class="h-4 mt-3">inactive {{ $mediaType }}</p>
                </div>
                <i class="align-self-center mr-3 fas fa-dizzy text-danger f-s-40"></i>
            </div>
        </div>
    </div>

</div>

<hr>

<div class="row">
    <div class="col-3">
        <div class="card card-shadow-hover">
            <div class="card-body">
                <h5 class="card-title">Tracking status changes</h5>

                <form action="{{ route('providers.showStatusChanges', ['mediaType' => $mediaType, 'providerId' => $provider->id]) }}" method="post" id="provider-status-changes-form">
                    <div class="form-group row">
                        <label for="example-date-input" class="col-12 col-form-label">After</label>
                        <div class="col-12">
                            <input class="form-control" name="date_after" type="date" value="" id="example-date-input">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-date-input" class="col-12 col-form-label">Before</label>
                        <div class="col-12">
                            <input class="form-control" name="date_before" type="date" value="" id="example-date-input">
                        </div>
                    </div>

                    <button type="button" id="provider-tracking-status-changes-find" class="btn btn-primary">apply</button>
                </form>

                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
        </div>
    </div>
    <div class="col-9">
        <div class="row" id="provider-tracking-statuses-container"></div>
    </div>
</div>

@push('scripts')
<script>
const ProviderStatusChanges = {
    submitBtn: $('#provider-tracking-status-changes-find'),
    form: $('#provider-status-changes-form'),
    resultContainer: $('#provider-tracking-statuses-container'),
    find: function () {
        ProviderStatusChanges.resultContainer.empty();

        let data = {
            date_after: ProviderStatusChanges.form.find('input[name="date_after"]').val(),
            date_before: ProviderStatusChanges.form.find('input[name="date_before"]').val()
        };

        $.ajax({
            url: ProviderStatusChanges.form.attr('action'),
            method: 'get',
            data: data,
            success: function (r) {
                ProviderStatusChanges.resultContainer.append(r);
            },
            error: function (e) {
                console.log(e);
                ProviderStatusChanges.resultContainer.empty();
                ProviderStatusChanges.resultContainer.html($('<span class="text-danger">An error happened.</span>'));
            }
        });
    }
};

ProviderStatusChanges.submitBtn.on('click', ProviderStatusChanges.find);
</script>

@endpush