<div class="mb-3 border-bottom">
    <b>Batch id:</b> <span class="float-right">{{ $item->batch_id ?? '-' }} [{{ $item->qaBatch->import_date ?? '' }}]</span>
</div>

<div class="mb-3 border-bottom">
    <b>Date added:</b> <span class="float-right">{{ now()->timestamp($item->date_added)->format('Y-m-d H:i:s') }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Date published:</b> <span class="float-right">{{ $item->date_published }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>MA release date:</b> <span class="float-right">{{ $item->ma_release_date }}</span>
</div>

<div class="mb-3 border-bottom">
    <b>Licensor:</b>
    <span class="float-right">
       <a title="show info about this licensor" href="{{ route('licensors.show', ['id' => $item->licensor_id]) }}" target="_blank">
           {{ $item->licensor_id }} [{{ $item->licensor->name ?? '' }}]
       </a>
    </span>
</div>

<div class="mb-3 border-bottom">
    <b>Premium:</b> <span class="float-right">{{ $item->premium }}</span>
</div>

{{--Metadata file name--}}
<div class="mb-3 border-bottom">
    <b>Feed:</b>
    <span class="float-right">
        <small>
            {{ \Ingestion\Search\Normalize::normalizeBucketName($item->licensor->name ?? '') }}/{{ str_replace(["Full_{$item->licensor->name}_", "Delta_{$item->licensor->name}_"], '', $item->qaBatch->title ?? '-') }}
        </small>
    </span>
</div>

<form method="POST" class="form-group" action="{{ ida_route('reports.parse.getMetadataIntoDatabase') }}" target="_blank">
    <input type="hidden" id="type" name="type" value="{{ $mediaType }}">
    <input type="hidden" id="id" name="id" value="{{ $item->id }}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <button type="submit" class="btn btn-info">Info by metadata file</button>
</form>
