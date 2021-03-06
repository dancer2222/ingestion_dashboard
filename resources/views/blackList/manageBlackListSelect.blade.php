@extends('template_v2.layouts.main')

@section('title', 'Black List')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h2 style="color: red">Select {{ $mediaType }} : <i style="color: green">{{ $authorName }}</i></h2>
            <div class="card">
                <form method="POST" class="form-control-feedback"
                      action="{{ route('blackList.blackList') }}">

                    <table class="table table-hover text-dark">
                        <thead>
                        <tr>
                            <th>
                                Id
                            </th>
                            <th>
                                Title
                            </th>
                            <th>
                                Add to BlackList
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($info as $item)
                            <tr>
                                <td><input type="hidden" name="media[{{ $item['id'] }}][id]"
                                           value="{{ $item['id'] }}"
                                           readonly><a
                                        href="{{ route('search', [ 'type' => str_replace('_', '', $mediaType), 'valueType' => 'id', 'id' => $item['id']]) }}"
                                        class="badge badge-pill badge-secondary"
                                        title="Click to see more info about this Id"
                                        target="_blank">{{ $item['id'] }}</a></td>
                                <td>{{ $item['title'] }}</td>
                                <td>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" name="media[{{ $item['id'] }}][checked]" checked>
                                        </div>
                                    </div>
                                </td>
                                <input type="hidden" name="mediaType" value="{{ $mediaType }}">
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <input type="hidden" name="command" value="{{ $command }}">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="dataType" value="{{ $dataType }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection