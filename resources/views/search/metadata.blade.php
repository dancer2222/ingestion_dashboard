@php
$headers = $messages->get('headers');
$items = $messages->get('items');
@endphp

<table class="table table-hover" border="2px">
    @if($headers)
    <tr>
        @foreach($headers as $header)
            @if($header !== 'description')
            <th style="background-color: green">{{ $header }}</th>
            @endif
        @endforeach
    </tr>
    @endif

    @if($items)
        @foreach($items as $item)
            <tr>
            @foreach($item as $headerName => $itemValue)
                @if($headerName !== 'description' && \in_array($headerName, $headers, true))
                <td>{{ $itemValue }}</td>
                @endif
            @endforeach
            </tr>
        @endforeach
    @endif
</table>
