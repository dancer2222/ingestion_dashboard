@if(Session::has('message'))
    <div class="alert alert-danger">
        {{  Session::get('message') }}
    </div>
@endif
@if(isset($message))
    <div class="alert alert-danger">
        {{ $message }}
    </div>
@endif