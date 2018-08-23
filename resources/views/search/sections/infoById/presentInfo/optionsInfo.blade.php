@foreach($info as $value => $item)
    @if(null == $item || is_array($item))

    @else
       @include('search.sections.infoById.presentInfo.parseInfo')
    @endif
@endforeach