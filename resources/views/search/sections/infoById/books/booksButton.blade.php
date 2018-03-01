<tr>
    <td>{{ $value }}</td>
    @if($item == 'inactive')
        <td style="color: red">{{ $item }}</td>
        <td>
            <form method="POST" class="form-control-feedback"
                  action="{{ action('ToolsController@doIt') }}">
                <input type="hidden" name="command" value="books:activate:byISBN">
                <input class="form-control" type="hidden" name="params[isbn]" value="{{ $info['isbn'] }}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-outline-success">Activate book</button>
            </form>
        </td>
    @else
        <td style="color: green">{{ $item }}</td>
        <td>
            <form method="POST" class="form-control-feedback"
                  action="{{ action('ToolsController@doIt') }}">
                <input type="hidden" name="command" value="books:deactivate:byISBN">
                <input class="form-control" type="hidden" name="params[isbn]" value="{{ $info['isbn'] }}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button type="submit" class="btn btn-outline-danger">Deactivate book</button>
            </form>
        </td>
    @endif
</tr>