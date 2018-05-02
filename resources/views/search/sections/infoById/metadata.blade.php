<tr>
    <td>Metadata</td>
    <td>
        <form method="POST" class="form-group" action="{{ ida_route('reports.parse.getMetadataIntoDatabase') }}" target="_blank">
            <input type="hidden" id="type" name="type" value="{{ $mediaTypeTitle }}">
            <input type="hidden" id="id" name="id" value="{{ $info['id'] }}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <button type="submit" class="btn btn-info">Info by metadata file</button>
        </form>
    </td>
    <td></td>
</tr>