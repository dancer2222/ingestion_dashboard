<div class="table-responsive">
    <table class="table table-hover text-dark" border="2px">
        <thead class="thead-dark">
        <tr>
            @foreach($info->first()->attributesToArray() as $product => $value)
                @switch($product)
                    @case('name')
                    <?php $product = 'Author Name'?>
                    @break

                    @case('status')
                    <?php $product = 'BlackList Status'?>
                    @break

                    @case('source')
                    <?php $product = 'Licensor'?>
                    @break

                    @case('data_source_provider_id')
                    <?php $product = 'Data source provider'?>
                    @break

                    @case('title')
                    <?php $product = 'Title'?>
                    @break

                    @case('book_id')
                    <?php $product = 'Book id'?>
                    @break

                    @case('audio_book_id')
                    <?php $product = 'Audiobook id'?>
                    @break

                    @case('created_at')
                    <?php $product = 'Created'?>
                    @break

                    @case('updated_at')
                    <?php $product = 'Updated'?>
                    @break

                @endswitch
                <th>
                    {{ $product }}
                </th>
            @endforeach
        </tr>
        </thead>
        @foreach($info->all() as $product)
            <tr>
                @foreach($product->attributesToArray() as $attrName => $attrValue)
                    @if($attrName === 'book_id' || $attrName === 'audio_book_id')
                        <td>
                            <a href="{{ route('search', ['type' => str_replace('_', '', $mediaType), 'valueType' => 'id','id' => $attrValue]) }}"
                               title="Click to see info about this Id"><span
                                        class="badge badge-pill badge-secondary">{{ $attrValue }}</span></a>
                        </td>
                        @continue
                    @elseif($attrName === 'data_source_provider_id')
                        <?php
                        $dataSourceProvider = new \App\Models\DataSourceProvider();

                        if ($dataSourceProvider->getDataSourceProviderName($attrValue)) {
                            $attrValue = $dataSourceProvider->getDataSourceProviderName($attrValue)->name;
                        }
                        ?>
                    @endif
                    <td><span class="badge badge-pill badge-light">{{ $attrValue }}</span></td>
                @endforeach
            </tr>
        @endforeach
    </table>
</div>

@if($info instanceof Illuminate\Pagination\LengthAwarePaginator)
<div class="d-flex">
    <div class="mr-auto p-2">
        {{ $info->appends(['limit' => request('limit', 10)])->links() }}
    </div>
    <div class="mr-auto p-2">
        <h3 style="font-weight: bold">Current page : {{ $info->currentPage() }}</h3>
    </div>
    <div class="p-2">
        <h3 style="font-weight: bold">Items per page :</h3>
    </div>
    <div class="p-2">
        <form action="{{ route('blackList.getInfoFromBlackList', ['mediaType' => $mediaType]) }}" method="get"
              class="form">
            <select class="custom-select" name="limit" onchange="$(this).closest('form').submit()">
                <option value="10" {{ request('limit') !== '10'  ?: 'selected' }}>10</option>
                <option value="20" {{ request('limit') !== '20'  ?: 'selected' }}>20</option>
                <option value="50" {{ request('limit') !== '50'  ?: 'selected' }}>50</option>
                <option value="100" {{ request('limit') !== '100'  ?: 'selected' }}>100</option>
            </select>
            <input type="hidden" name="page" value="{{ $info->currentPage() }}">
        </form>
    </div>
</div>
@endif


