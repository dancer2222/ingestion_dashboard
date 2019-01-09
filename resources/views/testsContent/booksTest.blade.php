@extends('template_v2.layouts.main')

@section('title', 'Tests books')

@section('content')

<h2>Select input file</h2>
    <div class="card">
        <form action="{{ route('tests.file') }}"
              method="post"
                enctype="multipart/form-data">
            <div class="form-group">
                <label for="Input_data">Enter the data for parsing</label>
                <input type="text" name="data">
            </div>
            <div class="form-group">
                <input type="file" name="file" style="width:800px" class="options_file_input">
            </div>
            <input type="hidden" name="mediaType" value="books">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type="submit" class="btn btn-primary mb-2">Parse data</button>
        </form>
    </div>
@endsection