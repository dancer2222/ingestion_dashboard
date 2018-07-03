@extends('template_v2.layouts.main')

@section('title', 'RabbitMQ - Indexation')

@section('content')

<div class="row">
    <div class="col-xl-5 col-lg-8 col-md-10 col-12 mx-auto">

        <div class="card">
            <div class="card-body">

                <form action="{{ route('indexation.store') }}" method="post" class="form">
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-xs-12 col-6">
                            <div class="form-group">
                                <label for="action">Action</label>

                                <select class="form-control custom-select" name="action" id="action">
                                    <option disabled {{ old('action') === null ? 'selected' : '' }}>Choose the action</option>

                                    <option value="updateSingle" {{ old('action') === 'updateSingle' ? 'selected' : '' }}>
                                        Update single
                                    </option>
                                    <option value="updateBatch" {{ old('action') === 'updateBatch' ? 'selected' : '' }}>
                                        Update batch
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-6">
                            <div class="form-group">
                                <label for="type">Content type</label>
                                <select class="form-control custom-select" name="type" id="type">
                                    <option disabled {{ old('type') === null ? 'selected' : '' }}>Choose the type</option>
                                    <option value="movies" {{ old('type') === 'movies' ? 'selected' : '' }}>
                                        Movies
                                    </option>
                                    <option value="audiobooks" {{ old('type') === 'audiobooks' ? 'selected' : '' }}>
                                        Audiobooks
                                    </option>
                                    <option value="books" {{ old('type') === 'books' ? 'selected' : '' }}>
                                        Books
                                    </option>
                                    <option value="albums" {{ old('type') === 'albums' ? 'selected' : '' }}>
                                        Albums
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="id">Id</label>

                                <input type="text" class="form-control" name="id" id="id" value="{{ old('id') }}">

                                <small class="form-text text-muted">
                                    Divide your ids by a comma
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn btn-dark">Submit</button>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

@endsection