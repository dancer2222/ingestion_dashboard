@foreach($info as $value => $item)

    @switch($value)
        @case('description')
        <tr>
            <td><a href="" data-toggle="collapse" data-target="#description"
                   class="badge badge-success">{{ $value }}</a><br>
            </td>
            <td id="description" class="collapse">
                {{ $item }}
            </td>
        </tr>
        @break

        @case('licensor_id')
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            <td>{{ $licensorName }}</td>
        </tr>
        @break

        @case('data_source_provider_id')
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            <td>{{ $providerName }}</td>
        </tr>
        @break

        @case('date_added')
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            <td>{{ date('Y-m-d', $item)}}</td>
        </tr>
        @break

        @case('emedia_release_date')
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            <td>{{ date('Y-m-d', $item)}}</td>
        </tr>
        @break

        @case('status')
        <tr>
            <td>{{ $value }}</td>
            @if($item == 'inactive')
                <td style="color: red">{{ $item }}</td>
            @else
                <td style="color: green">{{ $item }}</td>
            @endif
        </tr>
        @break

        @case('download_url')
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
        @break

        @case('batch_id')
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
        @break

        @default
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
        </tr>
    @endswitch
@endforeach