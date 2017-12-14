@if(Session::has('message'))
    <div class="alert {{ Session::has('error') ? 'alert-error' : 'alert-success' }} ">
        {{  Session::get('message') }}
    </div>
@endif
