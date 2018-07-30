@extends('template_v2.layouts.main')

@section('title', 'Aws - Notifications')

@section('content')

<div class="aws-notifications">

    <div class="row">
        <div class="col-12 mx-auto">

            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Choose date range and bucket name</h4>

                    <form class="form-inline" action="{{ route('aws.index') }}" method="get">

                        <div class="form-group">
                            <label for="from_date" class="sr-only">date from</label>
                            <input type="date" class="form-control" id="from_date" name="from_date" value="{{ request('from_date')}}">
                        </div>

                        <div class="form-group mx-sm-3">
                            <label for="to_date" class="sr-only">date to</label>
                            <input type="date" class="form-control" id="to_date" name="to_date" value="{{ request('to_date')}}">
                        </div>

                        <div class="form-group mx-sm-3">
                            <label for="bucket" class="sr-only">bucket</label>

                            <select class="form-control custom-select" name="bucket">
                                <option value="" selected disabled>Select bucket</option>

                                <option value="playster-book-service-dump" {{ request('bucket') !== 'playster-book-service-dump' ?: 'selected' }}>
                                    playster-book-service-dump
                                </option>
                                <option value="playster-content-ingestion" {{ request('bucket') !== 'playster-content-ingestion' ?: 'selected' }}>
                                    playster-content-ingestion
                                </option>
                            </select>
                        </div>

                        <input type="hidden" name="page" value="{{ request('page', 1) }}">

                        <button type="submit" class="btn btn-primary">Find</button>

                        <button type="button" id="reset" class="btn btn-outline-dark mx-sm-3">Reset filters</button>

                    </form>
                </div>
            </div>

        </div>
    </div>

    @if(isset($notifications) && $notifications)
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Notifications</h4>

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Event Time</th>
                                <th>Event Name</th>
                                <th>Bucket</th>
                                <th>File</th>
                                <th>File Size</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($notifications as $notification)
                            <tr>
                                <th scope="row">{{ $notification->id }}</th>
                                <td class="color-primary">{{ $notification->event_time }}</td>
                                <td>{{ $notification->event_name }}</td>
                                <td>{{ $notification->bucket }}</td>
                                <td>{{ $notification->key }}</td>
                                <td>{{ $notification->size }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{ $notifications->links() }}

    @endif

</div>
@endsection
