@extends('template_v2.layouts.main')

@section('title', 'Licensors')

@section('content')

<div class="row">
    <div class="col-12 card">

        @include('template_v2.misc.licensors.search_form')

        <div class="card-body">
            @if(isset($licensors))
                @include('template_v2.misc.licensors.licensors_list')
            @endif

            @if(isset($licensorContentItems))
                @include('template_v2.misc.licensors.licensor_content_list')
            @endif
        </div>

    </div>
</div>

@endsection
