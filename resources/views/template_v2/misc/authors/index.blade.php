@extends('template_v2.layouts.main')

@section('title', 'Authors')

@section('content')

<div class="row">
    <div class="col-12 card">
        @include('template_v2.misc.authors.search_form')

        @if(isset($authors) && !$authors->count())
            <span class="text-danger">
                No authors found for this query.
            </span>
        @endif

        <div class="card-body">

            @if(isset($authors) && $authors->count() && request()->author_type)
                @include('template_v2.misc.authors.authors_list')
            @endif

            @if(isset($author) && $books)
                @include('template_v2.misc.authors.authors_books_list')
            @endif

        </div>
    </div>
</div>

@endsection