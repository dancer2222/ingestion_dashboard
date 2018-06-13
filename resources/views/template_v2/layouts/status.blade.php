@if(!empty($status))

    <div class="col-12 alert alert-info alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        {{ $status }}
    </div>

@endif