@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    <table class="table table-hover" border="2px">
        <tr>
            @foreach($messages[0] as $item => $a)
                <th style="background-color: #2ca02c">
                    {{ $item }}
                </th>
            @endforeach
        </tr>
        @foreach($messages as $message)
            <tr>
                @foreach($message as $value)
                    <td>
                        <p style="font-size: 13px">{{ $value }}</p>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>

    <a class="btn btn-info" href="{{ URL::previous() }}">back</a>
@endsection
