@extends('layouts.main')

@section('title', $folderName)

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                @if(isset($error_message))

                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>{{ $error_message }}</strong>
                    </div>

                @else

                    @component('components.video-table', ['pages'=> $pages, 'videos' => $videos, 'request' => $request])
                    @endcomponent

                @endif
            </div>
        </div>
    </div>

@endsection