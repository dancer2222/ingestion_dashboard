@if(Session::has('message'))
    <div class="alert {{ Session::has('error') ? 'alert-danger' : 'alert-dark' }} ">
        {{  Session::get('message') }}
    </div>
@endif
