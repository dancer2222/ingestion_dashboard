@extends('template_v2.layouts.main')

@section('title', 'Tests books')

@section('content')
    <form method="POST" class="form-control-feedback"
          action="{{ route('tests.final') }}">
        <div class="row">
            @include('testsContent.buttons', ['name' => $filepath['filepathNotNowReleaseDate'], 'dataTarget' => '#notNowReleaseDate'])
            <div id="notNowReleaseDate" class="collapse table-responsive">
                <h2 class="text-center color-danger">{{ $filepath['filepathNotNowReleaseDate'] }}</h2>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            @if(empty($variableStatusItem['notNowReleaseDate']))
                                -
                            @else
                                @foreach($variableStatusItem['notNowReleaseDate'][0] as $item => $value)
                                    @if($value === "Empty")
                                        -
                                    @else
                                        <td class="text-left"><span style="font-weight: bold">{{ $item }}</span></td>
                                    @endif
                                @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                    @if(empty($variableStatusItem['notNowReleaseDate']))
                        <td class="text-left">Empty</td>
                    @else
                        @foreach($variableStatusItem['notNowReleaseDate'] as $item => $values)
                            @include('testsContent.foreachParseFull')
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            @include('testsContent.buttons', ['name' => $filepath['filepathActiveItem'], 'dataTarget' => '#activeItem'])
            <div id="activeItem" class="collapse table-responsive">
                <h2 class="text-center color-danger">{{ $filepath['filepathActiveItem'] }}</h2>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        @if(empty($variableStatusItem['activeItem']))
                            -
                        @else
                            @foreach($variableStatusItem['activeItem'][0] as $item => $value)
                                @if($value === "Empty")
                                    -
                                @else
                                    <td class="text-left"><span style="font-weight: bold">{{ $item }}</span></td>
                                @endif
                            @endforeach
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if(empty($variableStatusItem['activeItem']))
                        <td class="text-left">Empty</td>
                    @else
                        @foreach($variableStatusItem['activeItem'] as $item => $values)
                            @include('testsContent.shortForeachParse')
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            @include('testsContent.buttons', ['name' => $filepath['filepathLevelWarningItem'], 'dataTarget' => '#levelWarningItem'])
            <div id="levelWarningItem" class="collapse table-responsive">
                <h2 class="text-center color-danger">{{ $filepath['filepathLevelWarningItem'] }}</h2>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        @if(empty($variableStatusItem['levelWarningItem']))
                            -
                        @else
                            @foreach($variableStatusItem['levelWarningItem'][0] as $item => $value)
                                @if($value === "Empty")
                                    -
                                @else
                                    <td class="text-left"><span style="font-weight: bold">{{ $item }}</span></td>
                                @endif
                            @endforeach

                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if(empty($variableStatusItem['levelWarningItem']))
                        <td class="text-left">Empty</td>
                    @else
                        @foreach($variableStatusItem['levelWarningItem'] as $item => $values)
                            @include('testsContent.foreachParseFull')
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            @include('testsContent.buttons', ['name' => $filepath['filepathLevelCriticalItem'], 'dataTarget' => '#levelCriticalItem'])
            <div id="levelCriticalItem" class="collapse table-responsive">
                <h2 class="text-center color-danger">{{ $filepath['filepathLevelCriticalItem'] }}</h2>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        @if(empty($variableStatusItem['levelCriticalItem']))
                            -
                        @else
                            @foreach($variableStatusItem['levelCriticalItem'][0] as $item => $value)
                                @if($value === "Empty")
                                    -
                                @else
                                    <td class="text-left"><span style="font-weight: bold">{{ $item }}</span></td>
                                @endif
                            @endforeach
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if(empty($variableStatusItem['levelCriticalItem']))
                        <td class="text-left">Empty</td>
                    @else
                        @foreach($variableStatusItem['levelCriticalItem'] as $item => $values)
                            @include('testsContent.foreachParseFull')
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            @include('testsContent.buttons', ['name' => $filepath['filepathInactiveNotHaveFailedItem'], 'dataTarget' => '#inactiveNotHaveFailedItem'])
            <div id="inactiveNotHaveFailedItem" class="collapse table-responsive">
                <h2 class="text-center color-danger">{{ $filepath['filepathInactiveNotHaveFailedItem'] }}</h2>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        @if(empty($variableStatusItem['inactiveNotHaveFailedItem']))
                            -
                        @else
                            @foreach($variableStatusItem['inactiveNotHaveFailedItem'][0] as $item => $value)
                                @if($value === "Empty")
                                    -
                                @else
                                    <td class="text-left"><span style="font-weight: bold">{{ $item }}</span></td>
                                @endif
                            @endforeach
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @if(empty($variableStatusItem['inactiveNotHaveFailedItem']))
                        <td class="text-left">Empty</td>
                    @else
                        @foreach($variableStatusItem['inactiveNotHaveFailedItem'] as $item => $values)
                            @include('testsContent.shortForeachParse')
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>

            @include('testsContent.buttons', ['name' => $filepath['filepathNotFoundIsbn'], 'dataTarget' => '#notFoundIsbn'])
            <div id="notFoundIsbn" class="collapse table-responsive">
                <h2 class="text-center color-danger">{{ $filepath['filepathNotFoundIsbn'] }}</h2>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td>
                            Isbn
                        </td>
                    </tr>
                    </thead>
                    <tbody>
                    @if(empty($variableStatusItem['notFoundIsbn']))
                        <td class="text-left">Empty</td>
                    @else
                        @foreach($variableStatusItem['notFoundIsbn'] as $item => $value)
                            <tr>
                                @foreach($value as $values)
                                    <td class="text-left">{{ $values }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <button type="submit" class="btn btn-info btn-lg btn-block">Get final report</button>
    </form>
@endsection