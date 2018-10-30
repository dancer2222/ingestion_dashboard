@extends('template_v2.layouts.main')

@section('title', 'RabbitMQ - Indexation')

@section('content')
    <div class="row">
        <div class="col-xl-5 col-lg-8 col-md-10 col-12 mx-auto">

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('indexation.store') }}" method="post" class="form">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-xs-12 col-6">
                                <div class="form-group">
                                    <label for="action">Action</label>

                                    <select class="form-control custom-select" name="action" id="action">
                                        <option
                                            value="updateSingle">
                                            Update single
                                        </option>
                                        <option
                                            value="updateBatch">
                                            Update batch
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-12 col-6">
                                <div class="form-group">
                                    <label for="type">Content type</label>
                                    <select class="form-control custom-select" name="type" id="type">
                                        @foreach($single as $vType)
                                            <option
                                                value="{{ $vType }}" {{ $vType === 'updateSingle' ? 'selected' : '' }}>{{ $vType }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="id">Id</label>

                                    <input type="text" class="form-control" name="id" id="id" value="{{ old('id') }}">

                                    <small class="form-text text-muted">
                                        Divide your ids by a comma
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button class="btn btn-dark">Submit</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
    @push('scripts')
        <script>
            var Search = {
                elements: {
                    contentType: document.getElementById('action'),
                    valueType: document.getElementById('type')
                },
                valueTypesBatch: @php echo json_encode($batch) @endphp,
                valueTypesSingle: @php echo json_encode($single) @endphp,
                updateValueTypes: function () {
                    Search.elements.valueType.innerHTML = '';
                    var typesToDisplay = Search.elements.contentType.value === 'updateSingle' ? Search.valueTypesSingle : Search.valueTypesBatch;
                    for (var valueType of typesToDisplay) {
                        var option = document.createElement('option');
                        option.value = valueType;
                        option.innerText = valueType;
                        Search.elements.valueType.appendChild(option);
                    }
                }
            };

            Search.elements.contentType.addEventListener('change', Search.updateValueTypes);
        </script>
    @endpush
@endsection