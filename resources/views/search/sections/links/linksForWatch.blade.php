<div class="row m-t-15">
    <div class="col-6">

        <b>Show on playster this {{ $mediaTypeTitle }} - <a
                    href="{{ config('main.links.playster.prod') }}{{ $mediaTypeTitle }}/{{ $info['id']}}/{{$info['title']}}"
                    target="_blank"> {{ $info['title']}}</a></b>
    </div>

    <div class="col-6">
        <b>Show on QA playster this {{ $mediaTypeTitle }} - <a
                    href="{{ config('main.links.playster.qa') }}{{ $mediaTypeTitle }}/{{ $info['id']}}/{{$info['title']}}"
                    target="_blank">{{ $info['title'] }}</a></b>
    </div>
</div>




