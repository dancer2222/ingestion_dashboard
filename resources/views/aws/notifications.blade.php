@extends('layouts.main')

@section('title', 'Folders')

@section('content')
    @include('search.sections.message.errorGreen')
    @include('search.sections.message.error')
    <div class="container col-xs-8">
        <h3>Search by
            <span class="defaultDatabase">{{ config('database.default') }}</span>
        </h3>

        <form method="POST" class="form-control-feedback"
              action="{{ ida_route('aws.info') }}">
            <div class="row">
                <div class="col">
                    <input type="date" class="form-control" name="date"
                           value="{{ \Carbon\Carbon::createFromDate()->format('Y-m-d')}}">
                </div>
                <div class="col">
                    <select name="bucket" class="form-control">
                        <option value="playster-content-ingestion">playster-content-ingestion</option>
                        <option value="playster-book-service-dump">playster-book-service-dump</option>
                    </select>
                </div>
            </div>
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <br>
            <button type="submit" class="btn btn-outline-success">Submit</button>
            <a type="button" class="btn btn-outline-success" href="{{ ida_route('aws.index') }}">All notifications</a>
        </form>
        <br>
        @if(isset($products[0]))
            @include('aws.parseNotifications', $products)
        @endif
    </div>
@endsection

