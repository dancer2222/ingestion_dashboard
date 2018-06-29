@extends('template_v2.layouts.main')

@section('title', 'Black List')

@section('content')

    @include('search.sections.message.errorGreen')
    <div class="row">
        <div class="col-md-12">
            <h1 style="color: red">Select media type</h1>
            <div class="card">
                <div class="row p-t-20">
                    &nbsp; &nbsp;
                    <a href="{{ route('blackList.getInfoFromBlackList', ['mediaType' => 'books']) }} " class="btn btn-outline-primary">&nbsp;&nbsp; &nbsp;Books&nbsp; &nbsp;&nbsp;</a>
                    &nbsp; &nbsp;
                    <a href="{{ route('blackList.getInfoFromBlackList', ['mediaType' => 'audio_books']) }} " class="btn btn-outline-primary">Audiobooks</a>
                    &nbsp; &nbsp;
                    <form method="get" class="form-control-feedback"
                          action="{{ route('blackList.getInfoFromBlackList', ['mediaType' => 'books']) }}">
                        <div class="form-group">
                            <h5>Search book by id</h5>
                            <div class="input-group input-group-rounded">
                                <input type="text" placeholder="Type id" name="id" class="form-control">
                                <span class="input-group-btn"><button class="btn btn-primary btn-group-right" type="submit"><i class="ti-search"></i></button></span>
                            </div>
                        </div>
                    </form>
                    &nbsp; &nbsp;
                    <form method="get" class="form-control-feedback"
                          action="{{ route('blackList.getInfoFromBlackList', ['mediaType' => 'audio_books']) }}">
                        <div class="form-group">
                            <h5>Search audiobook by id</h5>
                            <div class="input-group input-group-rounded">
                                <input type="text" placeholder="Type id" name="id" class="form-control">
                                <span class="input-group-btn"><button class="btn btn-primary btn-group-right" type="submit"><i class="ti-search"></i></button></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(isset($info))
        @include('blackList.parseBlackListInfo', $info)
    @endif
@endsection