<tr>
    <td>Feed</td>
    <td>
        {{ $linkShow }}
        | <a href="" data-toggle="collapse" data-target="#link" class="badge badge-success">Link to copy</a>
        <div id="link" class="collapse">
            {{ $linkCopy }}
            @if($licensorName == 'aenetworks')
            @else
                <form method="POST" class="form-group" action="{{ action('ExcelController@index') }}">
                    <input type="hidden" id="bucket" name="bucket" value="{{ config('main.links.aws.bucket.movies') }}">
                    <input type="hidden" id="object" name="object" value="{{ $object }}">
                    <input type="hidden" id="title" name="batchTitle" value="{{ $batchInfo['title'] }}">
                    <input type="hidden" id="title" name="title" value="{{ $info->title }}">
                    <input type="hidden" id="id" name="id" value="{{ $info->id }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-info">Info by metadata file</button>
                </form>
             @endif
        </div>
    </td>
</tr>
@if(isset($brightcove_id))
<tr>
    <td>Brightcove_id</td>
    <td>{{ $brightcove_id }}</td>
</tr>
@endif