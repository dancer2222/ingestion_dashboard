@if ($errors->any())

    <div class="row">

        @foreach($errors->all() as $error)
        <div class="col-12 alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            {{ $error }}
        </div>
        @endforeach

    </div>

@endif