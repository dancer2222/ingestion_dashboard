@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    <div class="container">
        <div class="row">
            <form id="form_tools" action="{{ route('tools.index') }}" method="get" class="form-inline">
                <div class="col">
                    <h2>Type </h2>
                    <select name="type" id="" onchange="$('#form_tools').submit();"
                            class="form-control form-control-lg">
                        @foreach($data['types'] as $type)
                            <option value="{{ $type }}" {{ request()->has('type') && request()->get('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <h2>Action</h2>
                    <select name="action" id="" onchange="$('#form_tools').submit();"
                            class="form-control form-control-lg">
                        @foreach($data['actions'] as $action)
                            <option value="{{ $action }}" {{ request()->has('action') && request()->get('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        @if($commands)
            <br>
            <hr>
            <h2>Select tolls</h2>
            @foreach($commands as $command)
                <hr style="font-weight: bold; ">
                <div class="row">
                    <form method="POST" class="form-control-feedback" action="{{ action('ToolsController@doIt') }}">
                        <div class="form-group">
                            <label for="text"><h5>Description</h5></label>
                            <div class="input-group">
                                <input type="text" id="message" name="message" class="form-control">
                                <input type="hidden" id="id" name="id" value="1">
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            @endforeach
        @else
        @endif
    </div>
@endsection