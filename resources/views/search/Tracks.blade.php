@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.error')
    @include('search.sections.infoById.nonPresentId_url')
    <br>
    @if(isset($info))
        <div class="container">
            <table class="table table-hover">
                <th style="background-color: #2ca02c">
                    Field name
                </th>
                <th style="background-color: #2ca02c">
                    Data
                </th>
                <th style="background-color: #2ca02c">
                    For User
                </th>
                @if('yes' === $option)
                    @foreach($info as $value => $item)
                        @if(null == $item)

                        @else
                            @include('search.sections.infoById.albums.trackInfo')
                        @endif
                    @endforeach
                @else
                    @foreach($info as $value => $item)
                        @include('search.sections.infoById.albums.trackInfo')
                    @endforeach
                @endif
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
                                        <b style='color: green'>Active</b> --> <br>@foreach($country_code as &$item)
                                            @if($item['available_date'] == '0000-00-00')
                                                <?php $item['available_date'] = 'unavailable for streaming' ?>
                                            @endif
                                            @if(isset($item['status']))
                                                @if($item['status'] == 'active')
                                                    @if( in_array($item['region'],['US', 'CA', 'GB']))
                                                        <b style='color: red'>{{ $item['region'] }} [{{ $item['available_date'] }}]</b><br>
                                                    @else
                                                        {{ $item['region'] }} .  [{{ $item['available_date'] }}]<br>
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
                                        <b style='color: green'>Inactive</b> --> <br>@foreach($country_code as &$item)
                                            @if($item['available_date'] == '0000-00-00')
                                                <?php $item['available_date'] = 'unavailable for streaming' ?>
                                            @endif
                                            @if(isset($item['status']))
                                                @if($item['status'] == 'inactive')
                                                    @if( in_array($item['region'],['US', 'CA', 'GB']))
                                                        <b style='color: red'>{{ $item['region'] }} [{{ $item['available_date'] }}]</b><br>
                                                    @else
                                                        {{ $item['region'] }} [{{ $item['available_date'] }}]<br>
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
                </tr>
            </table>
        </div>
    @endif
@endsection