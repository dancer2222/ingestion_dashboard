@foreach($info as $value => $item)
    @if(null == $item)

    @else
        @if($value === 'description')
            <tr>
                <td><a href="" data-toggle="collapse"
                       data-target="#description">{{ $value }}</a><br></td>
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
        @else
            <tr>
                <td>{{ $value }}</td>
                <td>{{ $item }}</td>
            </tr>
        @endif
    @endif
@endforeach