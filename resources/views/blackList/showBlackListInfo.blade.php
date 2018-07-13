@extends('template_v2.layouts.main')

@section('title', 'Black List')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-title">
                <span class="text-danger float-left">Find by id</span>

                <span class="text-danger float-right">Show full list by type</span>
            </div>

            <div class="card-title">

                <form method="get" class="form-control-feedback float-left m-l-5 m-r-5" style="width: 300px"
                      action="{{ route('blackList.getInfoFromBlackList', ['mediaType' => 'books']) }}">
                    <div class="form-group">
                        <div class="input-group input-group-rounded">
                            <input type="text" placeholder="Book id" name="id" class="form-control">

                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-group-right" type="submit" style="padding: 8px 12px">
                                    <i class="ti-search"></i>
                                </button>
                            </span>
                        </div>

                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Boook id
                        </small>
                    </div>
                </form>

                <form method="get" class="form-control-feedback float-left m-l-5" style="width: 300px"
                      action="{{ route('blackList.getInfoFromBlackList', ['mediaType' => 'audio_books']) }}">
                    <div class="form-group">
                        <div class="input-group input-group-rounded">
                            <input type="text" placeholder="Audiobook id" name="id" class="form-control">

                            <span class="input-group-btn">
                                <button class="btn btn-primary btn-group-right" type="submit" style="padding: 8px 12px">
                                    <i class="ti-search"></i>
                                </button>
                            </span>
                        </div>

                        <small id="passwordHelpBlock" class="form-text text-muted">
                            Audiobook id
                        </small>
                    </div>
                </form>

                <div class="float-right">
                    <a href="{{ route('blackList.getInfoFromBlackList', ['mediaType' => 'books']) }} "
                       class="btn btn-outline-primary m-r-4">
                        Books
                    </a>

                    <a href="{{ route('blackList.getInfoFromBlackList', ['mediaType' => 'audio_books']) }} "
                       class="btn btn-outline-primary m-r-5">
                        Audiobooks
                    </a>
                </div>

            </div>

            <div class="card-body">
                @if(isset($info))
                    @include('blackList.parseBlackListInfo', $info)
                @endif
            </div>

        </div>
    </div>
</div>

@endsection