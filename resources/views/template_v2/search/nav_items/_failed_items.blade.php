@if(!is_null($failedItems))
<div class="tab-pane p-20" id="failed_items" role="tabpanel">
    <table class="table table-hover">
        <thead class="thead-dark">
        <tr>
            <th scope="col">id</th>
            <th scope="col">batch_id</th>
            <th scope="col">reason</th>
            <th scope="col">time</th>
            <th scope="col">level</th>
            <th scope="col">error_code</th>
            <th scope="col">status</th>
        </tr>
        </thead>

        <tbody>
        @foreach($failedItems as $message)
            <tr>
                <th>{{ $message->id }}</th>
                <th>{{ $message->batch_id }}</th>
                <th>{{ $message->reason }}</th>
                <th>{{ $message->time }}</th>
                <th>{{ $message->level }}</th>
                <th>{{ $message->error_code }}</th>
                <th>{{ $message->status }}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@else
    Not have failed items
@endif