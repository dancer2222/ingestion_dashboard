<div class="table-responsive">
<table class="table table-hover text-dark" border="2px">
    <thead class="thead-dark">
    <tr>
        @foreach($info[0] as $product => $value)
            <th>
                {{ $product }}
            </th>
        @endforeach
    </tr>
    </thead>
    @foreach($info as $product)
        <tr>
            @foreach($product as $item => $value)
                <td>
                    {{ $value }}
                </td>
            @endforeach
        </tr>
    @endforeach
</table>

@if($info instanceof Illuminate\Pagination\LengthAwarePaginator)
    {{ $info->links() }}
@endif
</div>