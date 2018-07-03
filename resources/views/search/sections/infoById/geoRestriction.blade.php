<tr>
    <td>Geo Restriction</td>

    <td colspan="2">
        <button type="button" class="btn btn-outline-success" data-toggle="collapse"
                data-target="#country_code">
            Show Geo Restriction
        </button>

        <div id="country_code" class="collapse">
            <ul class="nav flex-column text-left">
                <li class="nav-item">
                    <a class="nav-link disabled" href="#"><b>Active</b> -->

                    @foreach($country_code as $item)
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

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled" href="#"><b>Inactive</b> -->
                        @foreach($country_code as $item)
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
                    </a>
                </li>
            </ul>

        </div>
    </td>
</tr>