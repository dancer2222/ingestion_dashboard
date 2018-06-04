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

</tr>