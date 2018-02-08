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
                    @include('search.sections.infoById.presentInfo.optionsYes')
                @else
                    @include('search.sections.infoById.presentInfo.optionsNo')
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
                                        <b style='color: green'>Active</b> --> @foreach($country_code as $item)
                                            @if(isset($item['status']))
                                                @if($item['status'] == 'active')
                                                    @if( in_array($item['region'],['US', 'CA', 'GB']))
                                                        <b style='color: red'>{{ $item['region'] }}</b>
                                                    @else
                                                        {{ $item['region'] }}
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
                                                    @if( in_array($item['region'],['US', 'CA', 'GB']))
                                                        <b style='color: red'>{{ $item['region'] }}</b>
                                                    @else
                                                        {{ $item['region'] }}
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