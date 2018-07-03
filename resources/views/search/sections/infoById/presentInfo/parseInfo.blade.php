<tr>
    @switch($value)
        @case('description')

        <td colspan="3">
            <a href="" data-toggle="collapse"
               data-target="#description" class="badge badge-success float-left">
                {{ $value }}
            </a>
            <br>

            <div id="description" class="collapse text-left">{{ $item }}</div>
        </td>

        @break

        @case('licensor_id')

        <td>{{ $value }}</td>
        <td>{{ $item }}</td>
        <td>{{ $licensorName }}</td>

        @break

        @case('data_source_provider_id')

        <td>{{ $value }}</td>
        <td>{{ $item }}</td>
        <td>{{ $providerName }}</td>

        @break

        @case('date_added')

        <td>{{ $value }}</td>
        <td>{{ $item }}</td>
        <td>{{ date('Y-m-d', $item)}}</td>

        @break

        @case('emedia_release_date')

        <td>{{ $value }}</td>
        <td>{{ $item }}</td>
        <td>{{ date('Y-m-d', $item)}}</td>

        @break

        @case('status')

        @include('search.sections.infoById.status.buttons')

        @break

        @case('download_url')

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

        @break

        @case('batch_id')

        <td>{{ $value }}</td>
        <td>{{ $item }} [{{ $batchInfo['import_date'] }}]</td>
        <td>
            <form method="POST" class="form-group" id="report"
                  action="{{ route('reports.batch_report') }}">
                <input type="hidden" id="batch_id" name="batch_id" value="{{ $item }}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-success">Get batch report</button>
            </form>
        </td>

        @break

        @default

        <td>{{ $value }}</td>
        <td>{{ $item }}</td>
        <td></td>
    @endswitch
</tr>