<tr>
    <td>{{ $value }}</td>
    @php
        if ($item == 'inactive') {
            $tool = 'activate';
            $cssClass = 'text-danger';
        } else {
            $tool = 'deactivate';
            $cssClass = 'text-success';
        }
    @endphp

    <td class="{{ $cssClass }}">{{ $item }}</td>
    <td>
        <form method="POST" class="form-control-feedback"
              action="{{ route('tools.do') }}">
            <input type="hidden" name="command" value="books:{{ $tool }}:byISBN">
            <input class="form-control" type="hidden" name="params[isbn]" value="{{ $info['isbn'] }}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type="submit" class="btn btn-outline-success">{{ ucfirst($tool) }} book</button>
        </form>
    </td>
    <td>
        <button type="button" class="btn btn-outline-success" data-toggle="collapse"
                data-target="#statusInfo">Status info </button>
        <br>

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