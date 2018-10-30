@if(!empty($status))

    <div class="col-12 alert alert-info alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        {{ $status }}
    </div>

@endif

@if(Session::has('message'))
    <div class="alert {{ Session::has('error') ? 'alert-danger' : 'alert-info' }} ">
        {{  Session::get('message') }}
    </div>
@endif