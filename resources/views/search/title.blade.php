@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    <h3>Click to ID for more info</h3>
    <table class="table table-hover">
        <th style="background-color: #2ca02c">id</th>
        <th style="background-color: #2ca02c">title</th>
        <th style="background-color: #2ca02c">ma_release_date</th>
        <th style="background-color: #2ca02c">language</th>
        <th style="background-color: #2ca02c">download_url</th>
        <th style="background-color: #2ca02c">licensor_id</th>
        <th style="background-color: #2ca02c">status</th>
        <th style="background-color: #2ca02c">source</th>
        <th style="background-color: #2ca02c">batch_id</th>

        @foreach($info as $value)
            <tr>
                <td><a href="{{ action('SearchController@index', ['id' => $value->id]) }}" style="color: #b6a338; text-decoration: none; font-weight: bold;">{{ $value->id }}</a> </td>
                <td>{{ $value->title }}</td>
                <td>{{ $value->ma_release_date }}</td>
                <td>{{ $value->language }}</td>
                <td>{{ $value->download_url }}</td>
                <td>{{ $value->licensor_id }}</td>
                <td>{{ $value->status }}</td>
                <td>{{ $value->source }}</td>
                <td>{{ $value->batch_id }}</td>
            </tr>
        @endforeach
    </table>
    <br> <a href="{{ '/' }}" class="btn btn-info">BACK</a>
@endsection