<tr>
    <td>{{ $value }}</td>

    @php
        if ($item == 'inactive') {
            $command = 'active';
            $cssClass = 'text-danger';
        } else {
            $command = 'inactive';
            $cssClass = 'text-success';
        }

        if (isset($blackListStatus) && $blackListStatus !== 'active') {
            $commandBlackList = 'active';
            $blacklistButtonName = 'Add to BlackList';
        } else {
            $commandBlackList = 'inactive';
            $blacklistButtonName = 'Remove from BlackList';
        }
    @endphp

    <td class="{{ $cssClass }}">{{ $item }}</td>

    <td>
        <div class="btn-group">
            @role(['admin', 'ingester'])
            @if(isset($blackListStatus))
                @if($blackListStatus !== 'active')
                    <form method="POST" class="form-inline"
                          action="{{ route('changeStatus') }}" style="display: inline-block">
                        <input type="hidden" name="id" value="{{ $info['id'] }}">
                        <input type="hidden" name="command" value="{{ $command }}">
                        <input type="hidden" name="mediaType" value="{{ $mediaTypeTitle }}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit"
                                class="btn btn-outline-{{ 'active' === $item ?  'danger' : 'success'}} }}">
                            Set {{ ucfirst($command) }}</button>
                    </form>
                @else
                    <b>Unblacklist to activate</b> &nbsp;
                @endif
                @if('audiobooks' === $mediaTypeTitle || 'books' === $mediaTypeTitle)
                    @if('audiobooks' === $mediaTypeTitle)
                        <?php $mediaTypeTitle = 'audio_books'?>
                    @endif
                    <form method="POST" class="form-inline"
                          action="{{ route('blackList.blackList') }}" style="display: inline-block">
                        <input type="hidden" name="id" value="{{ $info['id'] }}">
                        <input type="hidden" name="command" value="{{ $commandBlackList }}">
                        <input type="hidden" name="dataType" value="idType">
                        <input type="hidden" name="mediaType" value="{{ $mediaTypeTitle }}">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="submit"
                                class="btn btn-outline-{{ 'inactive' === $blackListStatus ?  'danger' : 'success'}} }}">{{ ucfirst($blacklistButtonName) }}</button>
                    </form>
                @endif
            @endif
            @endrole

            <button type="button" class="btn btn-outline-success" data-toggle="collapse"
                    data-target="#statusInfo">Status info
            </button>
        </div>
        <div id="statusInfo" class="collapse m-t-10">
            @if(!is_null($statusInfo))
                <table class="table table-hover text-dark">
                    <tr>
                        <th>old_value</th>
                        <th>new_value</th>
                        <th>date_added</th>
                    </tr>
                    @foreach($statusInfo as $changes)
                        <tr>
                            <td>{{ $changes->old_value}}</td>
                            <td>{{ $changes->new_value }}</td>
                            <td>{{ date('Y-m-d', $changes->date_added) }}</td>
                        </tr>
                    @endforeach
                </table>
            @else
                <h3>Not info about status</h3>
            @endif
        </div>
    </td>
</tr>