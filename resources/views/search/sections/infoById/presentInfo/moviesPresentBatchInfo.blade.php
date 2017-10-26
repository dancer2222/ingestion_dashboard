<tr>
    <td>Feed</td>
    <td>
        {{ $linkShow }}
        | <a href="" data-toggle="collapse" data-target="#link">Link to copy</a>
        <div id="link" class="collapse">
            {{ $linkCopy }}
            <form method="POST" class="form-group" action="{{ action('ExcelController@index') }}">
                <input type="hidden" id="bucket" name="bucket" value="{{ config('main.links.aws.bucket.movies') }}">
                <input type="hidden" id="object" name="object" value="{{ $object }}">
                <input type="hidden" id="title" name="batchTitle" value="{{ $batchInfo->title }}">
                <input type="hidden" id="title" name="title" value="{{ $info['title'] }}">
                <input type="hidden" id="id" name="id" value="{{ $info['id'] }}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-info">Info by metadata file</button>
            </form>
        </div>
        <div class="loader" style="display: none;"><p style="font-weight: bold; color: red">Please
                wait for loading...</p></div>
        <div id="myModal" class="modal fade" role="dialog" tabindex="-1" aria-hidden="true">
            <div class="modal-lg modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" style="word-wrap: break-word;">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>