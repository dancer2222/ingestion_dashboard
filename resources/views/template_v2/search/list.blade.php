<div class="row">
    <div class="card col-12">
        <div class="card-body">

            <table class="table table-hover">

                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tile</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($list as $item)
                    <tr>
                        <th>{{ $item->id }}</th>
                        <td>{{ $item->title }}</td>
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