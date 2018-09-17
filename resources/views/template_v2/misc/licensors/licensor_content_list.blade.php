<hr>

<h3>Licensor</h3>

<ul>
    <li>ID: <b>{{ $licensor->id }}</b></li>
    <li>Name: <b>{{ $licensor->name }}</b></li>
    <li>Status: <b>{{ $licensor->status }}</b></li>
    <li>Media Type: <b>{{ $licensor->media_type }}</b></li>
</ul>

<table class="table mt-3">
    <thead class="thead-dark">
    <tr>
        <th colspan="3" class="text-center">{{ ucfirst($licensor->media_type) }}</th>
    </tr>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Batch ID</th>
    </tr>
    </thead>
    <tbody>
    @foreach($licensorContentItems as $item)
        <tr>
            <th scope="row">
                <a title="Click to see more info about this Id" href="{{ route('reports.show', ['mediaType' => $licensor->media_type, 'id' => $item->id]) }}">
                    {{ $item->id }}
                </a>

                <span class="pull-right badge badge-{{ $item->status === 'active' ? 'success' : 'secondary' }}">
                    {{ $item->status }}
                </span>
            </th>
            <td>
                <a title="Click to see more info about this Title" href="{{ route('reports.show', ['mediaType' => $licensor->media_type, 'id' => $item->id]) }}" class="font-weight-bold text-dark">
                    {{ $item->title }}
                </a>
            </td>
            <td>{{ $item->batch_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

@if($licensorContentItems && $licensorContentItems instanceof \Illuminate\Pagination\LengthAwarePaginator)
    {{ $licensorContentItems->links() }}
@endif
