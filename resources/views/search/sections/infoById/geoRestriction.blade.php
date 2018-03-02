<tr>
    <td>Geo Restriction</td>
    <td>
        <button type="button" class="btn btn-outline-success" data-toggle="collapse"
                data-target="#country_code">
            Show Geo Restriction
        </button>
        <div id="country_code" class="collapse">
            <table class="table table-hover">
                <tr>
                    <td>
                        <b style='color: green'>Active</b> --> @foreach($country_code as $item)
                            @if(isset($item['status']))
                                @if($item['status'] == 'active')
                                    @if( in_array($item['country_code'],['US', 'CA', 'GB']))
                                        <b style='color: red'>{{ $item['country_code'] }}</b>
                                    @else
                                        {{ $item['country_code'] }}
                                    @endif
                                @endif
                            @else
                                {{ $item }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td>
                        <b style='color: green'>Inactive</b> --> @foreach($country_code as $item)
                            @if(isset($item['status']))
                                @if($item['status'] == 'inactive')
                                    @if( in_array($item['country_code'],['US', 'CA', 'GB']))
                                        <b style='color: red'>{{ $item['country_code'] }}</b>
                                    @else
                                        {{ $item['country_code'] }}
                                    @endif
                                @endif
                            @else
                                {{ $item }}
                            @endif
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </td>
    <td></td>
</tr>