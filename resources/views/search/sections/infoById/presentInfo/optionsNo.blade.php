@foreach($info as $value => $item)
    @if($value === 'description')
        <tr>
            <td><a href="" data-toggle="collapse" data-target="#description">{{ $value }}</a><br>
            </td>
            <td id="description" class="collapse">
                {{ $item }}
            </td>
        </tr>
    @elseif($value === 'licensor_id')
        <tr>
            <td>Licensor</td>
            <td>[{{ $item }}]{{ $licensorName }}</td>
        </tr>
    @elseif($value === 'data_source_provider_id')
        <tr>
            <td>Data source provider</td>
            <td>[{{ $item }}]{{ $providerName }}</td>
        </tr>
    @elseif($value === 'date_added')
        <tr>
            <td>Date aded</td>
            <td>  {{ date('Y-m-d', $item)}}</td>
        </tr>
    @elseif($value === 'batch_id')
        <tr>
            <td>batch_id</td>
            <td>
                <form method="POST" class="form-group" id="report"
                      action="{{ action('BatchReportController@index') }}">
                    <label>{{ $item }} |</label>
                    <input type="hidden" id="batch_id" name="batch_id" value="{{ $item }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-success">Get batch report</button>
                </form>
            </td>
        </tr>
    @else
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
        </tr>
    @endif
@endforeach