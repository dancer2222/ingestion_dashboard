<div class="card mb-2">
    <div class="card-block">
        <form class="form-inline">

            <label class="mr-sm-2" for="select-page">Page:</label>
            <select class="suctom-select mb-2 mr-sm-2 mb-sm-0" id="select-page" onchange="redirect(this.value)">
                @for($i=1; $i <=$pages; $i++)
                    <option {{ isset($request['page']) && $i == $request['page'] ? 'selected' : '' }}
                            value="?{{ isset($request['q']) ? 'q=' . $request['q'] . '&' : ''}}page={{$i}}">
                        {{ $i }}
                    </option>
                @endfor
            </select>

        </form>
    </div>
</div>

<!-- Table -->
<table class="table table-hover table-bordered">
    <thead class="thead-inverse">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Complete</th>
        <th>State</th>
        <th>Created at</th>
        <th>Updated at</th>
    </tr>
    </thead>

    <tbody>
        @if(!count($videos))
            <td colspan="6">
                No results
            </td>
        @endif
    @foreach($videos as $video)

        <tr>
            <td>{{ $video['id'] }}</td>
            <td>{{ $video['name'] }}</td>
            <td>{{ $video['complete'] ? 'complete' : 'uncomplete' }}</td>
            <td>{{ $video['state'] }}</td>
            <td>{{ $video['created_at'] }}</td>
            <td>{{ $video['updated_at'] }}</td>
        </tr>

    @endforeach
    </tbody>

</table>