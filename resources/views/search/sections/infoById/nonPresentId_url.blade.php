<div class="row">
    @if(app()->environment('local'))
    <div class="col-12">
        <div class="card">
            <div class="card-title"></div>
            <div class="card-body">

                <div class="pull-left">
                    {{--<a class="btn btn-info" href="{{ route('search') }}">Search</a>--}}
                </div>

                <div class="pull-right">
                    <h3 class="text-muted">
                        Database connection: <b class="text-warning defaultDatabase">{{ config('database.default') }}</b>
                    </h3>
                </div>

            </div>
        </div>
    </div>
    @endif

    <div class="col-12">

        <div class="card">
            <div class="card-title"></div>
            <div class="card-body">

                <form id="form_tools" method="post" class="form" action="{{ route('reports.search_by_title') }}">

                    <div class="row">

                        <div class="col-3">
                            <div class="form-group">
                                <label for="content_type">
                                    <strong>Media type</strong>
                                </label>

                                <select name="contentType" id="content_type" class="form-control">
                                    @foreach($contentTypes as $cType)
                                        <option value="{{ $cType }}" {{ $cType === $contentType ? 'selected' : '' }}>
                                            {{ $cType }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        @isset($valueTypes)
                        <div class="col-3">
                            <div class="form-group">
                                <label for="value_type">
                                    <strong>Search by</strong>
                                </label>

                                <select name="valueType" id="value_type" class="form-control">
                                    @foreach($valueTypes as $vType)
                                        <option value="{{ $vType }}" {{ $vType === $valueType ? 'selected' : '' }}>{{ $vType }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endisset

                        <div class="col-6">
                            <div class="form-group">
                                <label for="value">
                                    <strong>Needle</strong>
                                </label>

                                <div class="input-group">
                                    <input type="text" name="value" id="value" class="form-control" aria-describedby="button-addon1">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit" id="button-addon1">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-12">
                            <a href="#otherActions" class="float-right text-primary" data-toggle="collapse"
                               aria-expanded="false" aria-controls="otherActions">
                                <strong><u>Other actions</u></strong>
                            </a>
                        </div>

                        {{-- Other actions --}}
                        <div class="col-12 collapse" id="otherActions">
                            <div class="row">

                                <div class="col-12">
                                    <hr>
                                </div>

                                <div class="col-6">

                                    <div class="card">
                                        <div class="card-title"></div>
                                        <div class="card-body">

                                            <form method="POST" class="form-control-feedback"
                                                  action="{{ route('reports.batch_report') }}">
                                                <div class="form-group">
                                                    <h3>
                                                        <label for="batch_id">
                                                            Generate Batch Report
                                                        </label>
                                                    </h3>

                                                    <input type="text" class="form-control" id="batch_id" name="batch_id" placeholder="Type batch id">

                                                    <small id="emailHelp" class="form-text text-info">Search by batch id</small>
                                                </div>
                                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                                <button type="submit" class="btn btn-outline-secondary">Submit</button>
                                            </form>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>

                    {{ csrf_field() }}
                </form>


            </div>
        </div>

    </div>

</div>

@push('scripts')
    <script>
        var Search = {
            elements: {
                contentType: document.getElementById('content_type'),
                valueType: document.getElementById('value_type'),
            },
            valueTypes: @php echo json_encode($valueTypesAll) @endphp,
            updateValueTypes: function () {
                if (!Search.valueTypes.hasOwnProperty(this.value)) {
                    return false;
                }

                Search.elements.valueType.innerHTML = '';

                for (var valueType of Search.valueTypes[this.value]) {
                    var option = document.createElement('option');
                    option.value = valueType;
                    option.innerText = valueType;

                    Search.elements.valueType.appendChild(option);
                }
            }
        };

        Search.elements.contentType.addEventListener('change', Search.updateValueTypes)
    </script>
@endpush