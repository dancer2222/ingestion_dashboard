<hr>
@if($licensors->count())
<table class="table table-hover mt-3">
    <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Media Type</th>
        </tr>
    </thead>
    <tbody>
    @foreach($licensors as $licensor)
        <tr>
            <th scope="row">
                {{ $licensor->id }}

                <span class="pull-right badge badge-{{ $licensor->status === 'active' ? 'success' : 'secondary' }}">
                    {{ $licensor->status }}
                </span>
            </th>
            <td>
                <a href="{{ route('licensors.show', ['id' => $licensor->id]) }}" class="font-weight-bold text-dark">
                    {{ $licensor->name }}
                </a>
            </td>
            <td>{{ $licensor->media_type }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@else
<div class="alert alert-danger" role="alert">
    No licensors found
</div>
@endif
