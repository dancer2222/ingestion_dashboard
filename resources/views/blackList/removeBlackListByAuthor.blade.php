@extends('template_v2.layouts.main')

@section('title', 'Black List')

@section('content')

    @include('search.sections.message.errorGreen')
    <div class="row">
        <div class="col-md-12">
            <h1 style="color: red">Remove by author id</h1>
            <div class="card">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#book" role="tab"><span
                                    class="hidden-sm-up"><i class="ti-home"></i></span> <span
                                    class="hidden-xs-down">Book</span></a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#audiobook" role="tab"><span
                                    class="hidden-sm-up"><i class="ti-user"></i></span> <span
                                    class="hidden-xs-down">Audiobook</span></a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabcontent-border">
                    <div class="tab-pane active" id="book" role="tabpanel">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">

                                    <form method="POST" class="form-control-feedback"
                                          action="{{ route('blackList.blackListByAuthor') }}">
                                        <div class="form-group">
                                            <h3>
                                                <label for="batch_id">
                                                    Add to BlackList by Author id
                                                </label>
                                            </h3>

                                            <input type="text" class="form-control" id="author_id" name="author_id" placeholder="Type name">

                                            <small id="emailHelp" class="form-text text-info">Add to Black list by Author id
                                            </small>
                                        </div>
                                        <input type="hidden" name="mediaType" id="mediaType" value="book">
                                        <input type="hidden" name="command" value="inactive">
                                        <input type="hidden" name="model" value="book">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <button type="submit" class="btn btn-outline-secondary">Submit</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane  p-20" id="audiobook" role="tabpanel">
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">

                                    <form method="POST" class="form-control-feedback"
                                          action="{{ route('blackList.blackListByAuthor') }}">
                                        <div class="form-group">
                                            <h3>
                                                <label for="batch_id">
                                                    Add to BlackList by Author id
                                                </label>
                                            </h3>

                                            <input type="text" class="form-control" id="author_id" name="author_id" placeholder="Type name">

                                            <small id="emailHelp" class="form-text text-info">Add to Black list by Author id
                                            </small>
                                        </div>
                                        <input type="hidden" name="mediaType" id="mediaType" value="audio_books">
                                        <input type="hidden" name="command" value="inactive">
                                        <input type="hidden" name="model" value="audio_book">
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <button type="submit" class="btn btn-outline-secondary">Submit</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection