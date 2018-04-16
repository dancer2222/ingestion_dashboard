@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.error')

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

        <div class="col">
            <div class="row pb-3" id="tools-accordion">

            @foreach($commands as $commandName => $params)

                @php
                    $commandId = str_replace(':', '_', $commandName);
                    $toolTarget = $commandId . '-' . $loop->iteration;
                @endphp

                    <div class="card col-11 p-0 mx-auto">
                        <div class="card-header" id="{{ $commandId }}">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#{{ $toolTarget }}" aria-expanded="false" aria-controls="{{$toolTarget}}">
                                    {{ $commandName }}
                                </button>
                            </h5>
                        </div>

                        <div id="{{ $toolTarget }}" class="collapse" aria-labelledby="{{ $commandId }}" data-parent="#tools-accordion">
                            <div class="card-body">

                                <form method="POST" class="" action="{{ ida_route('tools.do', ['command' => $commandName ]) }}">

                                    {{-- Tool Arguments --}}
                                    @if($params['arguments'])

                                        @foreach($params['arguments'] as $argumentName => $argumentParams)
                                            @php
                                                $isRequired = isset($argumentParams['isRequired']) && $argumentParams['isRequired'];
                                            @endphp

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox"
                                                    {{ $isRequired ? 'disabled checked' : '' }}
                                                    id="arguments-{{$argumentName}}"
                                                    name="arguments[{{$argumentName}}]"
                                                    value="{{ $isRequired ? 'on' : '' }}"
                                                    class="custom-control-input">


                                                <label class="custom-control-label" for="arguments-{{$argumentName}}">
                                                    {{ $argumentName }} {{ $isRequired ? '*' : '' }}
                                                </label>

                                                @if ($isRequired)
                                                    <small id="arguments-{{$argumentName}}-help" class="{{$isRequired ? '' : 'hidden'}} form-text text-muted">
                                                        It was checked automatically since this argument is required
                                                    </small>
                                                @endif
                                            </div>
                                        @endforeach

                                        <hr>

                                    @endif

                                    {{-- Tool options --}}
                                    @foreach($params['options'] as $optionName => $optionParams)
                                        @php
                                            $isRequired = isset($optionParams['isRequired']) && $optionParams['isRequired'];
                                        @endphp

                                        <div class="form-group tool-options-group">
                                            <h5>
                                                <label for="option-{{$optionName}}">
                                                    {{ $optionName }} {{ $isRequired ? '*' : '' }}
                                                </label>

                                                <a href="#" class="text-info float-right tool-option-from-file tool-options-buttons"
                                                    role="button"
                                                    data-toggle="popover"
                                                    data-trigger="hover"
                                                    data-container="body"
                                                    data-content="Upload file with your data separated by a comma, space or new line. (It's usually used for ids)"
                                                    data-trigger-file="{{ $commandId . '_' . $optionName . '_file' }}">
                                                    <i class="fas fa-upload"></i>
                                                </a>
                                            </h5>

                                            <input class="form-control" type="text"
                                                id="option-{{$optionName}}"
                                                name="options[{{$optionName}}]"
                                                {{ $isRequired ? 'required' : ''}}>

                                            <small class="form-text text-muted">
                                                {{ $optionParams['description'] }}
                                            </small>

                                            <input type="file"
                                                   name="{{ $commandId . '_' . $optionName . '_file' }}"
                                                   id="{{ $commandId . '_' . $optionName . '_file' }}"
                                                   class="options_file_input"
                                                   data-url="{{ ida_route('tools.optionFromFile') }}"
                                                   data-option-name="{{ $optionName }}"
                                                   hidden>
                                        </div>

                                    @endforeach

                                    {{ csrf_field() }}

                                    <button type="submit" class="btn btn-default mb-3">Submit</button>
                                </form>

                            </div>
                        </div>

                    </div>

            @endforeach
            </div>
        </div>

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