@extends('template_v2.layouts.main')

@section('title', 'Black List')

@section('content')

    @include('search.sections.message.errorGreen')
    <div class="row">
        <div class="col-md-12">
            <h2 style="color: red">Select {{ $mediaType }} remove from BlackList by author: <i style="color: green">{{ $authorName }}</i></h2>
            <div class="card">
                <form method="POST" class="form-control-feedback"
                      action="{{ route('blackList.blackList') }}">
                    <div class="table-responsive">
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
                                   Remove from BlackList
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($info as $item)
                                <tr>
                                    <td><input type="hidden" name="media[{{ $item['id'] }}][id]" value="{{ $item['id'] }}"
                                               readonly>{{ $item['id'] }}</td>
                                    <td>{{ $item['title'] }}</td>
                                    <td>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <input type="checkbox" name="media[{{ $item['id'] }}][checked]" checked>
                                            </div>
                                        </div>
                                    </td>
                                    <input type="hidden" name="command" value="inactive">
                                    <input type="hidden" name="mediaType" value="{{ $mediaType }}">
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-success btn-lg btn-block">Submit</button>
                </form>
            </div>
        </div>
    </div>

@endsection