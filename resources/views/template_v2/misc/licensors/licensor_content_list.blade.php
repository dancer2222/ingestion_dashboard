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
                {{ $item->id }}

                <span class="pull-right badge badge-{{ $item->status === 'active' ? 'success' : 'secondary' }}">
                    {{ $item->status }}
                </span>
            </th>
            <td>
                <a href="" class="font-weight-bold text-dark">
                    {{ $item->title }}
                </a>
            </td>
            <td>{{ $item->batch_id }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
