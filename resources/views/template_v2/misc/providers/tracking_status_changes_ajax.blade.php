@isset($activeContent)
<div class="col-md-4">
    <div class="card p-30 card-shadow-hover">
        <div class="media">
            <div class="media-body">
                <h5 class="mt-0 mb-1">{{ $activeContent }}</h5>
                <p class="h-4 mt-3">tracking status changes (active)</p>
            </div>
            <i class="align-self-center mr-3 fas fa-smile text-success f-s-40"></i>
        </div>
    </div>
</div>
@endisset

@isset($inactiveContent)
<div class="col-md-4">
    <div class="card p-30 card-shadow-hover">
        <div class="media">
            <div class="media-body">
                <h5 class="mt-0 mb-1">{{ $inactiveContent }}</h5>
                <p class="h-4 mt-3">tracking status changes (inactive)</p>
            </div>
            <i class="align-self-center mr-3 fas fa-dizzy text-danger f-s-40"></i>
        </div>
    </div>
</div>
@endisset