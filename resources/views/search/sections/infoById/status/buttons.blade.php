<tr>
    <td>{{ $value }}</td>
    @php
        if ($item == 'inactive') {
            $tool = 'activate';
            $blackList = 'blackList.update';
            $status = 'Remove from BlackList';
            $cssClass = 'text-danger';
        } else {
            $tool = 'deactivate';
            $blackList = 'blackList.store';
            $status = 'Add in BlackList';
            $cssClass = 'text-success';
        }
    @endphp

    <td class="{{ $cssClass }}">{{ $item }}</td>
    <td>
        <form method="POST" class="form-inline"
              action="{{ route('tools.do') }}" style="display: inline-block">
            <input type="hidden" name="command" value="books:{{ $tool }}:byISBN">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type="submit" class="btn btn-outline-success">{{ ucfirst($tool) }}</button>
        </form>

        <form method="POST" class="form-inline"
              action="{{ route($blackList) }}" style="display: inline-block">
            <input type="hidden" name="id" value="{{ $info['id'] }}">
            <input type="hidden" name="mediaType" value="{{ $mediaTypeTitle }}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type="submit" class="btn btn-outline-success">{{ ucfirst($status) }}</button>
        </form>

        <button type="button" class="btn btn-outline-success" data-toggle="collapse"
                data-target="#statusInfo">Status info
        </button>

        <div id="statusInfo" class="collapse m-t-10">
            @if(!is_null($statusInfo))
                <table class="table-responsive">
                    <tr>
                        <th style="background-color: #2ca02c">old_value</th>
                        <th style="background-color: #2ca02c">new_value</th>
                        <th style="background-color: #2ca02c">date_added</th>
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
                Not info
            @endif
        </div>
    </td>
</tr>