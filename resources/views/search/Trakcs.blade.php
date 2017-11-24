@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.error')
    @if(isset($id_url))
        @include('search.sections.infoById.presentId_url')
    @else
        @include('search.sections.infoById.nonPresentId_url')
    @endif

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
            </table>
        </div>
    @endif
@endsection