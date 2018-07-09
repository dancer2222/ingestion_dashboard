@extends('template_v2.layouts.main')

@section('title', 'Black List')

@section('content')

    @include('search.sections.message.errorGreen')
    <div class="row">
        <div class="col-md-12">
            <h1 style="color: red">Manage BlackList</h1>
            <div class="card">
                <div class="tab-pane  p-20" id="audiobook" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <form method="POST" class="form-control-feedback"
                                  action="{{ route('blackList.blackListSelect') }}">
                                <div class="form-group">
                                    <h3>
                                        <label for="batch_id">
                                            Select your action
                                        </label>
                                    </h3>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">ID</span>
                                        </div>
                                        <input type="text" class="form-control" id="id" name="id" placeholder="Type id">
                                    </div>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Action</label>
                                        </div>
                                        <select class="custom-select" name="command">
                                            <option value="active" {{ 'active' == \Illuminate\Support\Facades\Request::session()->get('command') ? 'selected' : '' }}>
                                                Add
                                            </option>
                                            <option value="inactive" {{ 'inactive' == \Illuminate\Support\Facades\Request::session()->get('command') ? 'selected' : '' }}>
                                                Remove
                                            </option>
                                        </select>
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Type data</label>
                                        </div>
                                        <select class="custom-select" name="dataType">
                                            <option value="ids" {{ 'ids' == \Illuminate\Support\Facades\Request::session()->get('dataType') ? 'selected' : '' }}>
                                                Ids
                                            </option>
                                            <option value="author" {{ 'author' == \Illuminate\Support\Facades\Request::session()->get('dataType') ? 'selected' : '' }}>
                                                Author id
                                            </option>
                                        </select>
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">MediaType</label>
                                        </div>
                                        <select class="custom-select" name="mediaType">
                                            <option value="books" {{ 'books' == \Illuminate\Support\Facades\Request::session()->get('mediaType') ? 'selected' : '' }}>
                                                books
                                            </option>
                                            <option value="audio_books" {{ 'audio_books' == \Illuminate\Support\Facades\Request::session()->get('mediaType') ? 'selected' : '' }}>
                                                audiobooks
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" class="btn btn-outline-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection