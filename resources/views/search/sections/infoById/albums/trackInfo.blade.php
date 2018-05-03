@switch($value)
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

    @default
    <tr>
        <td>{{ $value }}</td>
        <td>{{ $item }}</td>
    </tr>
@endswitch