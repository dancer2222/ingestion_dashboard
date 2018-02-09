<tr>
    <td>Image url in bucket</td>
    <td>{{ $linkImageInBucket }}</td>
    @if($response == 1)
        <td style="color: green">Present in the bucket</td>
    @else
        <td style="color: red">Not present in the bucket</td>
    @endif
</tr>
<tr>
    <td>Feed</td>
    <td>
        {{ $linkShow }}
        | <a href="" data-toggle="collapse" data-target="#link" class="badge badge-success">Link to copy</a>
        <div id="link" class="collapse">
            {{ $linkCopy }}
            <form method="POST" class="form-group" id="form"
                  action="{{ action('ParseController@index') }}" target="_blank">
                <input type="hidden" id="bucket" name="bucket" value="{{ config('main.links.aws.bucket.books') }}">
                <input type="hidden" id="object" name="object" value="{{ $object }}">
                <input type="hidden" id="batchTitle" name="batchTitle"
                       value="{{ $batchInfo['title'] }}">
                <input type="hidden" id="title" name="title" value="{{ $info['title'] }}">
                <input type="hidden" id="id" name="id" value="{{ $info['id'] }}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-info">Info by metadata file</button>
            </form>
        </div>
    </td>
</tr>
