<div class="row">
    <div class="col">
        <b>Show on playster this {{ $mediaTypeTitle }} - <a
                href="{{ config('main.links.playster.prod') }}{{ $mediaTypeTitle }}/{{ $info->id}}/{{$info->title}}"
                target="_blank"> {{ $info->title }}</a></b>
    </div>
    <div class="col">
        <b>Show on QA playster this {{ $mediaTypeTitle }} - <a
                href="{{ config('main.links.playster.qa') }}{{ $mediaTypeTitle }}/{{ $info->id}}/{{$info->title}}"
                target="_blank">{{ $info->title }}</a></b>
    </div>
</div>




