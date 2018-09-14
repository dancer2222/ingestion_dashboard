<hr>

<table class="table table-hover table-bordered">
    <thead class="thead-dark">
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Info</th>
    </tr>
    </thead>

    <tbody>
    @foreach($authors as $author)
        @php
            $books = $author->books;
        @endphp
        <tr>
            <td>
                {{ $author->id }}
                <span class="font-weight-bold badge badge-{{ $author->status === 'active' ? 'success' : 'secondary' }}">
                    {{ $author->status }}
                </span>
            </td>

            <td>
                <a href="{{ route('authors.show', ['id' => $author->id, 'author_type' => request()->author_type]) }}" class="font-weight-bold text-dark">
                    {{ $author->name }}
                </a>
            </td>

            <td>
                <a href="{{ route('authors.show', ['id' => $author->id, 'author_type' => request()->author_type, 'status' => 'active']) }}" class="badge badge-success font-weight-bold">
                    active books
                    {{ $author->books->where('status', 'active')->count() }}
                </a>

                <a href="{{ route('authors.show', ['id' => $author->id, 'author_type' => request()->author_type, 'status' => 'inactive']) }}" class="badge badge-secondary font-weight-bold">
                    inactive books
                    {{ $author->books->where('status', 'inactive')->count() }}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

@if($authors && $authors instanceof \Illuminate\Pagination\LengthAwarePaginator)
    @php
        $appends = [];

        if (request()->needle) {
            $appends['needle'] = request()->needle;
        }

        if (request()->author_type) {
            $appends['author_type'] = request()->author_type;
        }
    @endphp
    <div class="mt-4">
    {{ $authors->appends($appends)->links() }}
    </div>
@endif