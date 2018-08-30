@if(!$books)
    No books found
@else
    <hr>

    <div class="text-dark mb-3">
        <div>
            <span class="font-weight-bold">Author ID:</span>
            {{ $author->id }}
        </div>
        <div>
            <span class="font-weight-bold">Name:</span>
            {{ $author->name }}
        </div>
        <div>
            <span class="font-weight-bold">Status:</span>
            {{ $author->status }}
        </div>
    </div>

    <table class="table table-striped table-hover table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Batch ID</th>
            </tr>
        </thead>

        <tbody>
            @foreach($books as $book)
            <tr>
                <td scope="row">
                    {{ $book->id }}
                    <span class="font-weight-bold badge badge-{{ $book->status === 'active' ? 'success' : 'secondary' }}">
                        {{ $book->status }}
                    </span>
                </td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->batch_id }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif

