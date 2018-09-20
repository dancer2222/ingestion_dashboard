@if($failedItems->count())
<div class="tab-pane p-20" id="failed_items" role="tabpanel">
    <table class="table table-hover">
        <tbody>
        @foreach($failedItems as $message)
            <tr>
                <th>
                    <div class="row">
                        <div class="col-6">
                            <span class="float-left text-left font-weight-bold">ID:</span>
                            <span class="float-right text-right">{{ $message->id }}</span>
                        </div>

                        <div class="col-6">
                            <span class="float-left text-left font-weight-bold">Date:</span>
                            <span class="float-right text-right">{{ $message->time }}</span>
                        </div>

                        <div class="col-6">
                            <span class="float-left text-left font-weight-bold">Level:</span>
                            <span class="float-right text-right">{{ $message->level }}</span>
                        </div>

                        <div class="col-6">
                            <span class="float-left text-left font-weight-bold">Status:</span>
                            <span class="float-right text-right text-{{ $message->status === 'active' ? 'success' : 'danger' }}">{{ $message->status }}</span>
                        </div>

                        <div class="col-6">
                            <span class="font-weight-bold">Error code:</span> {{ $message->error_code }}
                        </div>

                        <div class="col-6">
                            <span class="font-weight-bold">Reason:</span> {{ $message->reason }}
                        </div>
                    </div>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@else
    Not have failed items
@endif