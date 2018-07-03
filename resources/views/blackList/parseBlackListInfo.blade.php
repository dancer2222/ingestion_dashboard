<div class="table-responsive">
<table class="table table-hover text-dark" border="2px">
    <thead class="thead-dark">
    <tr>
        @foreach($info->first()->attributesToArray() as $product => $value)
            <th>
                {{ $product }}
            </th>
        @endforeach
    </tr>
    </thead>
    @foreach($info->all() as $product)
        <tr>
            @foreach($product->attributesToArray() as $attrName => $attrValue)
                <td>{{ $attrValue }}</td>
            @endforeach
        </tr>
    @endforeach
</table>

@if($info instanceof Illuminate\Pagination\LengthAwarePaginator)
    {{ $info->links() }}
@endif
</div>