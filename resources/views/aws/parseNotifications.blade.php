<table class="table table-hover" border="2px">
    <tr>
        @foreach($products[0]->toArray() as $product => $value)
        <th style="background-color: #2ca02c">
            {{ $product }}
        </th>
        @endforeach
    </tr>
    @foreach($products as $product)
    <tr>
        @foreach($product->toArray() as $item => $value)
        <td>
            {{ $value }}
        </td>
        @endforeach
    </tr>
    @endforeach
</table>
@if($products instanceof Illuminate\Pagination\LengthAwarePaginator)
{{ $products->links() }}
@endif
