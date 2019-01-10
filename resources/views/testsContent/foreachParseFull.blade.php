    @if(isset($values[0]))
        <td class="text-left">Empty</td>
    @else
        <?php $substrId = substr($values['id'], 1) ?>
        <tr>
            @foreach($values as $value => $item)
                @if('id' === $value)
                    <td><input type="hidden" name="media[{{ $substrId }}][id]"
                               value="{{ '`' . $substrId }}" readonly>
                        <a href="{{ route('reports.show', [ 'mediaType' => 'books',
                                                'needle' => $substrId]) }}"
                           class="badge badge-pill badge-secondary"
                           title="Click to see more info about this Id"
                           target="_blank">{{ $substrId }}</a></td>
                @else
                    <td class="text-left">{{ $item }}</td>
                @endif
            @endforeach
            <td class="text-left">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <input type="checkbox" name="media[{{ $substrId }}][checked]" checked>
                        <input type="hidden" name="media[{{ $substrId }}][isbn]" value="{{ $values['isbn'] }}">
                    </div>
                </div>
            </td>
        </tr>
    @endif
