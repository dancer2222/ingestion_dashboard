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
    @elseif($value === 'file_format_type_id')
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
            @if($item == 1)
                <td>pdf</td>
            @else
                <td>epub</td>
            @endif
        </tr>
    @else
        <tr>
            <td>{{ $value }}</td>
            <td>{{ $item }}</td>
        </tr>
    @endif
@endforeach