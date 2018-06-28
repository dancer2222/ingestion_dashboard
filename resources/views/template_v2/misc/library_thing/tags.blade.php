@extends('template_v2.layouts.main')

@section('title', 'Library Thing - Xml feeds')

@section('content')

    <div class="row">

        <div class="col-12 col-lg-6">
            <div class="card">
                @if($localFeeds)
                <div class="card-title">Local files</div>

                <div class="card-body">
                    <ul>
                    @foreach($localFeeds as $feed)
                        <li>{{ $feed }}</li>
                    @endforeach
                    </ul>
                </div>
                @elseif(isset($remoteFeeds) && !empty($remoteFeeds))
                <div class="card-title">
                    Remote files
                </div>

                <div class="card-body">
                    <ul>
                        @foreach($remoteFeeds as $remoteFeed)
                            <li class="m-b-5 border-bottom-1">
                                {{ $remoteFeed }}

                                <button class="btn btn-outline-info btn-xs">
                                    Download
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>

    </div>

@endsection
