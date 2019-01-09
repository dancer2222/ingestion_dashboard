<div class="col-sm">
    <div class="card">
        <h4 class="text-center">{{ $name }}</h4>
        <div class="row">
            <div class="col-sm text-center">
                <a href="" data-toggle="collapse" data-target="{{ $dataTarget }}"
                   class="btn btn-outline-success">Show</a>
            </div>
            <div class="col-sm text-center">
                <a href="{{ route('tests.download', ['fileName' => $name]) }}"
                   class="btn btn-outline-info">Download</a>
            </div>
        </div>

    </div>
</div>