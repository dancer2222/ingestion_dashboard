<tr>
    <td>
        {{ $item->id }}

        <span class="pull-right">
            <span class="badge badge-{{ $item->status === 'active' ? 'success' : 'secondary' }}">{{ $item->status }}</span>

            <a href="{{ config('main.links.playster.qa') }}{{ $contentTypeLower }}/{{ $item->id }}" class="badge badge-dark" target="_blank">qa</a>
            <a href="{{ config('main.links.playster.prod') }}{{ $contentTypeLower }}/{{ $item->id }}" class="badge badge-dark" target="_blank">prod</a>
        </span>
    </td>

    <td>{{ $item->title }}</td>
    <td>{{ $item->rating->rating }} ({{ $item->rating->votes_total }} total votes)</td>

    <td>
        <div class="btn-group" role="group" aria-label="Basic example">
            <a href="#" class="btn btn-secondary disabled">
                <i class="fas fa-trash text-danger"></i>
            </a>
        </div>
    </td>
</tr>