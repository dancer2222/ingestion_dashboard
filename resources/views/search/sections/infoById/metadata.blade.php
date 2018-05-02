<tr>
    <td>Metadata</td>
    <td>
        <button type="button" class="btn btn-outline-success" data-toggle="collapse"
                data-target="#metadata">Metadata
        </button>
        <br>
        <div id="metadata" class="collapse">
            <ul style="list-style-type:none">
                @foreach($metadata as $metadataTitle => $valueMetadata)
                    <li><b style="text-align: left">{{ $metadataTitle }}</b> - {{ $valueMetadata }}</li>
                @endforeach
            </ul>
        </div>
    </td>
    <td></td>
</tr>