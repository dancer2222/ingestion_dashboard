@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.errorGreen')
    <div class="container">
        <div class="row container-ida">

            <div class="col-12 p-3 mb-3 border-bottom">
                <form id="form_tools" action="{{ ida_route('tools.index') }}" method="get" class="form-inline">
                    <div class="form-group">
                        <h3 class="mx-sm-3">
                            <label for="tool_type">
                                Type
                            </label>
                        </h3>

                        <select name="type" id="tool_type" onchange="$('#form_tools').submit();"
                                class="form-control">
                            @foreach($data['types'] as $type)
                                <option value="{{ $type }}" {{ request()->has('type') && request()->get('type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mx-sm-3">

                        <h3 class="mx-sm-3">
                            <label for="tool_action">Action</label>
                        </h3>

                        <select name="action" id="tool_action" onchange="$('#form_tools').submit();"
                                class="form-control">
                            @foreach($data['actions'] as $action)
                                <option value="{{ $action }}" {{ request()->has('action') && request()->get('action') == $action ? 'selected' : '' }}>{{ $action }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>

        @if($commands)

        @foreach($commands as $command => $item)

            <div class="col-6">
                <form method="POST" class="" action="{{ action('ToolsController@doIt', ['command' => $command ]) }}">
                    <legend class="col-form-label col-sm-2 pt-0">
                        <h3>
                        {{ $command }}
                        </h3>
                    </legend>

                    @foreach($data['params'][$command]['arguments'] as $argumentName => $argumentValue)
                        @php
                            $isRequired = isset($argumentValue['isRequired']) && $argumentValue['isRequired'];
                        @endphp

                        <div class="custom-control custom-checkbox">
                            <input type="checkbox"
                                   {{ $isRequired ? 'disabled checked' : '' }}
                                   id="arguments-{{$argumentName}}"
                                   name="arguments[{{$argumentName}}]"
                                   value="{{ $isRequired ? 'on' : '' }}"
                                   class="custom-control-input">


                            <label class="custom-control-label" for="arguments-{{$argumentName}}">
                                {{ $argumentName }}
                            </label>

                            @if ($isRequired)
                            <small id="arguments-{{$argumentName}}-help" class="{{$isRequired ? '' : 'hidden'}} form-text text-muted">
                                It was checked automatically since this argument is required
                            </small>
                            @endif
                        </div>

                    @endforeach

                    @foreach($data['params'][$command]['options'] as $optionName => $optionValue)
                        @php
                            $isRequired = isset($argumentValue['isRequired']) && $argumentValue['isRequired'];
                        @endphp

                        <div class="form-group">
                            <h5>
                                <label for="option-{{$optionName}}">
                                    {{ $optionName }}
                                </label>
                            </h5>

                            <input class="form-control" type="text"
                                   id="option-{{$optionName}}"
                                   name="params[{{$optionName}}]"
                                    {{ $isRequired ? 'required' : ''}}>

                            <small class="form-text text-muted">
                                {{ $optionValue['description'] }}
                            </small>
                        </div>

                    @endforeach

                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-default mb-3">Submit</button>
                </form>
            </div>

            @endforeach

        </div>
        @else

        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                Tools were not found by this query
            </div>
        </div>

        @endif

    </div>
@endsection