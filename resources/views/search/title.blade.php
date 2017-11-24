@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    <h3>Click to ID for more info</h3>
    <table class="table table-hover" border="2px">
        <tr>
            @foreach($info[0] as $item => $a)
                <th style="background-color: #2ca02c">
                    {{ $item }}
                </th>
            @endforeach
        </tr>
        @foreach($info as $message)
            <tr>
                @foreach($message as $value => $item)
                    @if($item == null or $item == '')
                        <td>
                            <p style="font-size: 13px">0</p>
                        </td>
                    @elseif($value == 'id')
                        <td><a href="{{ action('SearchController@index', ['id' => $item, 'option' => 'yes']) }}" style="color: #b6a338; text-decoration: none; font-weight: bold;">{{ $item }}</a> </td>
                    @else
                        <td>
                            <p style="font-size: 13px">{{ $item }}</p>
                        </td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </table>
    <br> <a href="{{ '/' }}" class="btn btn-info">BACK</a>
@endsection