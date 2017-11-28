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
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            <td>{{ $licensorName }}</td>
        </tr>
    @elseif($value === 'data_source_provider_id')
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            <td>{{ $providerName }}</td>
        </tr>
    @elseif($value === 'date_added')
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            <td>{{ date('Y-m-d', $item)}}</td>
        </tr>
    @elseif($value === 'emedia_release_date')
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            <td>{{ date('Y-m-d', $item)}}</td>
        </tr>
    @elseif($value === 'status')
        <tr>
            <td>{{ $value }}</td>
            @if($item == 'inactive')
                <td style="color: red">{{ $item }}</td>
            @else
                <td style="color: green">{{ $item }}</td>
            @endif
        </tr>
    @elseif($value === 'download_url')
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            @if(isset($presentEpub))
                @if($presentEpub == 1)
                    <td style="color: green">Present in the bucket</td>
                @elseif(isset($http_response_header))
                    <td style="color: #67b168">{{ $http_response_header }}</td>
                @else
                    <td style="color: red">Not present in the bucket</td>
                @endif
            @endif
        </tr>
    @elseif($value === 'batch_id')
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            <td>
                <form method="POST" class="form-group" id="report"
                      action="{{ action('BatchReportController@index') }}">
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