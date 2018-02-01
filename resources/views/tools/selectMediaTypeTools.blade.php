@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.errorGreen')
    <div class="container" style="background-color: wheat; padding: 50px 50px 50px 50px; border-radius: 10px">
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
            <h2>Select tolls:</h2>
            @foreach($commands as $command => $item)
                <hr style="font-weight: bold; ">
                <div class="row">
                    <form method="POST" class="form-control-feedback"
                          action="{{ action('ToolsController@doIt', ['command' => $command ]) }}">
                        <label for="text"><h2>{{ $command }}</h2></label><br>
                        @foreach($data['params'][$command]['arguments'] as $argumentName => $argumentValue)
                            @if($argumentValue['isRequired'] == true)
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="hidden" name="arguments[{{$argumentName}}]" value="on"><h5
                                                style="color: red">{{ $argumentName }}  {{ $argumentValue['isRequired'] ? 'required' : '' }}</h5>
                                    </label>
                                </div>
                            @else
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="arguments[{{$argumentName}}]">
                                        <h5>{{ $argumentName }}  {{ $argumentValue['isRequired'] ? 'required' : '' }}</h5>
                                    </label>
                                </div>
                            @endif
                        @endforeach
                        @foreach($data['params'][$command]['options'] as $optionName => $optionValue)
                            <label for="text"><h5>{{ $optionValue['description'] }}</h5></label>
                            <div class="input-group">
                                <div class="input-group-addon">{{ $optionName }}
                                    - {{ $optionValue['isRequired'] ? 'required' : '' }}</div>
                                <input class="form-control" type="text" name="params[{{$optionName}}]">
                            </div>
                        @endforeach
                        <br>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <br>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </div>
            @endforeach
        @else
        @endif
    </div>
@endsection