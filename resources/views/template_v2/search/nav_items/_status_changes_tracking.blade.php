<div class="tab-pane p-20" id="status_info" role="tabpanel">
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">From</th>
            <th scope="col">To</th>
            <th scope="col">Date added</th>
        </tr>
        </thead>

        <tbody>
        @foreach($statusChangesTracking as $statusInfo)
            <tr>
                <th scope="row">{{ $statusInfo->id }}</th>
                <td>{{ $statusInfo->old_value }}</td>
                <td>{{ $statusInfo->new_value }}</td>
                <td>{{ $statusInfo->date_added }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>