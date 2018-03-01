@foreach($info as $value => $item)

    @if(null == $item)

    @else
        <tr>
        @switch($value)
            @case('description')

                <td><a href="" data-toggle="collapse"
                       data-target="#description" class="badge badge-success">{{ $value }}</a><br></td>
                <td>
                    <div id="description" class="collapse">{{ $item }}</div>
                </td>
                <td></td>

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
            @if('books' === $mediaTypeTitle)
                @include('search.sections.infoById.books.booksButton')
            @else

                <td>{{ $value }}</td>
                @if($item == 'inactive')
                    <td style="color: red">{{ $item }}</td>
                @else
                    <td style="color: green">{{ $item }}</td>
                @endif

                <td></td>

            @endif
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
                <td>{{ $item }}</td>
                <td>
                    <form method="POST" class="form-group" id="report"
                          action="{{ action('BatchReportController@index') }}">
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
    @endif
@endforeach