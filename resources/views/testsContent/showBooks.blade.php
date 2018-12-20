@extends('template_v2.layouts.main')

@section('title', 'Tests books')

@section('content')

    <div class="row">
        <div class="col-sm">
            <div class="card">
                <h4 class="text-center">{{ $filepathNotNowReleaseDate }}</h4>
                <div class="row">
                    <div class="col-sm text-center">
                        <a href="" data-toggle="collapse" data-target="#notNowReleaseDate"
                           class="btn btn-outline-success">Show</a>
                    </div>
                    <div class="col-sm text-center">
                        <a href="{{ route('tests.download', ['fileName' => $filepathNotNowReleaseDate]) }}"
                           class="btn btn-outline-info">Download</a>
                    </div>
                </div>

            </div>
        </div>
        <div id="notNowReleaseDate" class="collapse table-responsive">
            <h2 class="text-center color-danger">{{ $filepathNotNowReleaseDate }}</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    @if(empty($notNowReleaseDate))
                        -
                    @else
                        @foreach($notNowReleaseDate[0] as $item => $value)
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
                @if(empty($notNowReleaseDate))
                    <td class="text-left">Empty</td>
                @else
                    @foreach($notNowReleaseDate as $item => $value)
                        @if(isset($value[0]))
                            <td class="text-left">Empty</td>
                        @else
                            <tr onclick="window.location.href='{{ route('reports.show',
                            ['mediaType' => 'books', 'id' => substr($value['id'], 1)]) }}';
                                return false" style="cursor: pointer">
                                @foreach($value as $values)
                                    <td class="text-left">{{ $values }}</td>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

        <div class="col-sm">
            <div class="card">
                <h4 class="text-center">{{ $filepathActiveItem }}</h4>
                <div class="row">
                    <div class="col-sm text-center">
                        <a href="" data-toggle="collapse" data-target="#activeItem"
                           class="btn btn-outline-success">Show</a>
                    </div>
                    <div class="col-sm text-center">
                        <a href="{{ route('tests.download', ['fileName' => $filepathActiveItem]) }}"
                           class="btn btn-outline-info">Download</a>
                    </div>
                </div>

            </div>
        </div>
        <div id="activeItem" class="collapse table-responsive">
            <h2 class="text-center color-danger">{{ $filepathActiveItem }}</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    @if(empty($activeItem))
                        -
                    @else
                        @foreach($activeItem[0] as $item => $value)
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
                @if(empty($activeItem))
                    <td class="text-left">Empty</td>
                @else
                    @foreach($activeItem as $item => $value)
                        @if(isset($value[0]))
                            <td class="text-left">Empty</td>
                        @else
                            <tr onclick="window.location.href='{{ route('reports.show',
                            ['mediaType' => 'books', 'id' => substr($value['id'], 1)]) }}';
                                return false" style="cursor: pointer">
                                @foreach($value as $values)
                                    <td class="text-left">{{ $values }}</td>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

        <div class="col-sm">
            <div class="card">
                <h4 class="text-center">{{ $filepathLevelWarningItem }}</h4>
                <div class="row">
                    <div class="col-sm text-center">
                        <a href="" data-toggle="collapse" data-target="#levelWarningItem"
                           class="btn btn-outline-success">Show</a>
                    </div>
                    <div class="col-sm text-center">
                        <a href="{{ route('tests.download', ['fileName' => $filepathLevelWarningItem]) }}"
                           class="btn btn-outline-info">Download</a>
                    </div>
                </div>

            </div>
        </div>
        <div id="levelWarningItem" class="collapse table-responsive">
            <h2 class="text-center color-danger">{{ $filepathLevelWarningItem }}</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    @if(empty($levelWarningItem))
                        -
                    @else
                        @foreach($levelWarningItem[0] as $item => $value)
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
                @if(empty($levelWarningItem))
                    <td class="text-left">Empty</td>
                @else
                    @foreach($levelWarningItem as $item => $value)
                        @if(isset($value[0]))
                            <td class="text-left">Empty</td>
                        @else
                            <tr onclick="window.location.href='{{ route('reports.show',
                            ['mediaType' => 'books', 'id' => substr($value['id'], 1)]) }}';
                                return false" style="cursor: pointer">
                                @foreach($value as $values)
                                    <td class="text-left">{{ $values }}</td>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

    </div>

    <div class="row">
        <div class="col-sm">
            <div class="card">
                <h4 class="text-center">{{ $filepathLevelCriticalItem }}</h4>
                <div class="row">
                    <div class="col-sm text-center">
                        <a href="" data-toggle="collapse" data-target="#levelCriticalItem"
                           class="btn btn-outline-success">Show</a>
                    </div>
                    <div class="col-sm text-center">
                        <a href="{{ route('tests.download', ['fileName' => $filepathLevelCriticalItem]) }}"
                           class="btn btn-outline-info">Download</a>
                    </div>
                </div>

            </div>
        </div>
        <div id="levelCriticalItem" class="collapse table-responsive">
            <h2 class="text-center color-danger">{{ $filepathLevelCriticalItem }}</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    @if(empty($levelCriticalItem))
                        -
                    @else
                        @foreach($levelCriticalItem[0] as $item => $value)
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
                @if(empty($levelCriticalItem))
                    <td class="text-left">Empty</td>
                @else
                    @foreach($levelCriticalItem as $item => $value)
                        @if(isset($value[0]))
                            <td class="text-left">Empty</td>
                        @else
                            <tr onclick="window.location.href='{{ route('reports.show',
                            ['mediaType' => 'books', 'id' => substr($value['id'], 1)]) }}';
                                return false" style="cursor: pointer">
                                @foreach($value as $values)
                                    <td class="text-left">{{ $values }}</td>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

        <div class="col-sm">
            <div class="card">
                <h4 class="text-center">{{ $filepathInactiveNotHaveFailedItem }}</h4>
                <div class="row">
                    <div class="col-sm text-center">
                        <a href="" data-toggle="collapse" data-target="#inactiveNotHaveFailedItem"
                           class="btn btn-outline-success">Show</a>
                    </div>
                    <div class="col-sm text-center">
                        <a href="{{ route('tests.download', ['fileName' => $filepathInactiveNotHaveFailedItem]) }}"
                           class="btn btn-outline-info">Download</a>
                    </div>
                </div>

            </div>
        </div>
        <div id="inactiveNotHaveFailedItem" class="collapse table-responsive">
            <h2 class="text-center color-danger">{{ $filepathInactiveNotHaveFailedItem }}</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    @if(empty($inactiveNotHaveFailedItem))
                        -
                    @else
                        @foreach($inactiveNotHaveFailedItem[0] as $item => $value)
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
                @if(empty($inactiveNotHaveFailedItem))
                    <td class="text-left">Empty</td>
                @else
                    @foreach($inactiveNotHaveFailedItem as $item => $value)
                        @if(isset($value[0]))
                            <td class="text-left">Empty</td>
                        @else
                            <tr onclick="window.location.href='{{ route('reports.show',
                            ['mediaType' => 'books', 'id' => substr($value['id'], 1)]) }}';
                                return false" style="cursor: pointer">
                                @foreach($value as $values)
                                    <td class="text-left">{{ $values }}</td>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

        <div class="col-sm">
            <div class="card">
                <h4 class="text-center">{{ $filepathNotFoundIsbn }}</h4>
                <div class="row">
                    <div class="col-sm text-center">
                        <a href="" data-toggle="collapse" data-target="#notFoundIsbn"
                           class="btn btn-outline-success">Show</a>
                    </div>
                    <div class="col-sm text-center">
                        <a href="{{ route('tests.download', ['fileName' => $filepathNotFoundIsbn]) }}"
                           class="btn btn-outline-info">Download</a>
                    </div>
                </div>
            </div>
        </div>
        <div id="notFoundIsbn" class="collapse table-responsive">
            <h2 class="text-center color-danger">{{ $filepathNotFoundIsbn }}</h2>
            <table class="table table-hover">
                <thead>
                <tr>
                    <td>
                        Isbn
                    </td>
                </tr>
                </thead>
                <tbody>
                @if(empty($notFoundIsbn))
                    <td class="text-left">Empty</td>
                @else
                    @foreach($notFoundIsbn as $item => $value)
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

@endsection