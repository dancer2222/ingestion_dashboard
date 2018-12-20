@extends('template_v2.layouts.main')

@section('title', 'Tests books')

@section('content')

<h2>Select input file</h2>
    <div class="card">
        <form action="{{ route('tests.file') }}"
              method="post"
                enctype="multipart/form-data">
            <div lass="form-group">
                <label for="Input_data">Input data</label>
                <input type="text" name="data">
            </div>
            <div class="form-group">
                <label for="exampleFormControlFile">Example file input</label>
                <input type="file" name="file" class="options_file_input">
            </div>
            <input type="hidden" name="mediaType" value="books">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type="submit" class="btn btn-primary mb-2">Confirm identity</button>
        </form>
    </div>
@endsection