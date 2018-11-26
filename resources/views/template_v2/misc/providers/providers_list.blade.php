<hr>
@if($providers->count())
    <table class="table table-hover mt-3">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
        </tr>
        </thead>
        <tbody>
        @foreach($providers as $provider)
            <tr onclick="location.assign('{{ route('providers.show', ['media_type' => $media_types->where('media_type_id', $provider->qaBatch->media_type_id)->first()->title,'id' => $provider->id]) }}')"
                data-url="{{ route('providers.show', ['media_type' => $media_types->where('media_type_id', $provider->qaBatch->media_type_id)->first()->title, 'id' => $provider->id]) }}"
                style="cursor: pointer;">
                <th scope="row">
                    {{ $provider->id }}
                </th>
                <td>
                    <a href="javascript:void(0);" class="font-weight-bold text-dark">
                        {{ $provider->name }}
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-danger" role="alert">
        No providers found
    </div>
@endif
