<table class="table table-hover" border="2px">
    <tr>
        @if(isset($messages[0]))
            @foreach($messages[0] as $item => $a)
                @if($item !== 'description')
                <th style="background-color: #2ca02c">
                    {{ $item }}
                </th>
                @endif
            @endforeach
        @endif
    </tr>
    @foreach($messages as $message)
        <tr>
            @foreach($message as $name => $value)
                @if($name !== 'description')
                <td>
                    <p style="font-size: 13px">{{ $value }}</p>
                </td>
                @endif
            @endforeach
        </tr>
    @endforeach
</table>
