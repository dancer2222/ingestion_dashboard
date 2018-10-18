<div class="row">
    <div class="card col-12">
        <div class="card-body">

            <table class="table table-hover">

                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Title</th>
                        <th scope="col" class="text-left">Licensor</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($list as $item)
                    <tr class="search-list-tr">
                        <td>
                            <a title="Click to see more info about this Id" class="d-block"
                               href="{{ route('reports.show', ['mediaType' => $mediaType, 'id' => $item->id]) }}">
                                {{ $item->id }}
                            </a>
                        </td>
                        <td>
                            <a title="Click to see more info about this Title" class="d-block"
                               href="{{ route('reports.show', ['mediaType' => $mediaType, 'id' => $item->id]) }}">
                                {{ $item->title }}
                            </a>
                        </td>
                        <td class="text-left">
                            <a title="Click to see more info about this Licensor" class="d-block"
                               href="{{ route('licensors.show', ['id' => $item->licensor_id]) }}">
                                {{ $item->licensor->name ?? ''}}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

            @if($list instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php
                $appends = [];

                if (request()->needle) {
                    $appends['needle'] = request()->needle;
                }
            @endphp

            <div class="mt-3">
                {{ $list->appends($appends)->links() }}
            </div>

            @endif

        </div>
    </div>
</div>