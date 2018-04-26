@foreach($info as $value => $item)
    @if(null == $item)

    @else
       @include('search.sections.infoById.presentInfo.parseInfo')
    @endif
@endforeach