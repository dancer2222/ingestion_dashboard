@php
    $filterIsActive = in_array('active', $statuses);
    $filterIsInactive = in_array('inactive', $statuses);
    $filterTrackingStatusActive = in_array('active', $trackingStatuses);
    $filterTrackingStatusInactive = in_array('inactive', $trackingStatuses);
@endphp

<hr>

<h3>
    Provider

    {{--<a href="{{ route('providers.export.content', ['media_type' => request()->get('media_type'), 'id' => $provider->id]) }}" class="btn btn-outline-info btn-sm float-right" target="_blank">--}}
        {{--Export CSV--}}
    {{--</a>--}}
</h3>

<div class="row">
    <ul class="col-sm-12 col-md-6">
        <li>ID: <b>{{ $provider->id }}</b></li>
        <li>Name: <b>{{ $provider->name }}</b></li>
        <li>Media Type: <b>{{ $mediaType }}</b></li>
    </ul>
</div>

<table class="table mt-3">
    <thead class="thead-dark">
    <tr>
        <th class="bg-white" colspan="3">
            <a class="color-primary text-underline float-left" data-toggle="collapse"  href="#collapseFilter"
               role="button" aria-expanded="false" aria-controls="collapseFilter"
                onclick="$(this).find('i').hasClass('fa-arrow-down') ? $(this).find('i.fa-arrow-down').removeClass('fa-arrow-down').addClass('fa-arrow-up') : $(this).find('i.fa-arrow-up').removeClass('fa-arrow-up').addClass('fa-arrow-down');">
                <u>
                    Filter
                    <i class="fas fa-arrow-down"></i>
                </u>
            </a>

            <br>

            <div class="collapse col mb-4" id="collapseFilter">
                <form class="row" action="{{ route('providers.show', ['media_type' => $mediaType, 'id' => $provider->id]) }}" method="get">
                    <div class="col">
                        <div class="text-dark text-left">Status</div>
                        <div class="btn-group btn-group-toggle btn-group-sm float-left" data-toggle="buttons">
                            <label class="btn btn-outline-secondary color-success {{ $filterIsActive ? 'active' : '' }}" for="status_active">
                                <input type="checkbox" id="status_active" name="status[]" class="custom-control-input" value="active"
                                        {{ $filterIsActive ? 'checked' : '' }}>
                                active
                            </label>

                            <label class="btn btn-outline-secondary {{ $filterIsInactive ? 'active' : '' }}" for="status_inactive">
                                <input type="checkbox" id="status_inactive" name="status[]" class="custom-control-input" value="inactive"
                                        {{ $filterIsInactive ? 'checked' : '' }}>
                                inactive
                            </label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="text-dark text-left">Tracking status changes</div>
                        <div class="btn-group btn-group-toggle btn-group-sm float-left" data-toggle="buttons">
                            <label class="btn btn-outline-secondary color-success {{ $filterTrackingStatusActive ? 'active' : '' }}" for="status_tracking_active">
                                <input type="checkbox" id="status_tracking_active" name="status_tracking[]" class="custom-control-input" value="active"
                                        {{ $filterTrackingStatusActive ? 'checked' : '' }}>
                                active
                            </label>

                            <label class="btn btn-outline-secondary {{ $filterTrackingStatusInactive ? 'active' : '' }}" for="status_tracking_inactive">
                                <input type="checkbox" id="status_tracking_inactive" name="status_tracking[]" class="custom-control-input" value="inactive"
                                        {{ $filterTrackingStatusInactive ? 'checked' : '' }}>
                                inactive
                            </label>
                        </div>

                        <div>
                            <input type="date" class="form-control" name="tracking_date" value="{{ $trackingDate }}">
                        </div>
                    </div>

                    <hr>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-sm btn-primary pl-5 pr-5 float-left">apply</button>
                    </div>
                </form>
            </div>
        </th>
    </tr>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Batch ID</th>
    </tr>
    </thead>
    <tbody>
    @foreach($providerContentList as $item)
        <tr>
            <th scope="row">
                <a title="Click to see more info about this Id" href="{{ route('reports.show', ['mediaType' => $mediaType, 'id' => $item->id]) }}">
                    {{ $item->id }}
                </a>

                <span class="pull-right badge badge-{{ $item->status === 'active' ? 'success' : 'secondary' }}">
                    {{ $item->status }}
                </span>
            </th>
            <td>
                <a title="Click to see more info about this Title" href="{{ route('reports.show', ['mediaType' => $mediaType, 'id' => $item->id]) }}" class="font-weight-bold text-dark">
                    {{ $item->title }}
                </a>
            </td>
            <td>{{ $item->batch_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@if($providerContentList && $providerContentList instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $providerContentList->links() }}
@endif
