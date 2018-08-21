<tr>
    <button type="button" class="btn btn-warning" data-toggle="collapse" data-target="#aud">Show audibook products
    </button>

    <div id="aud" class="collapse">
        <ul class="list-group">
            @if(!empty($products))
                @foreach($products as $product)
                    <li class="list-group-item">
                        <button type="button" class="btn btn-info" data-parent="#aud" data-toggle="collapse"
                                data-target="#{{ $product['product_id'] }}" aria-expanded="false" aria-controls="{{ $product['product_id'] }}">
                            {{ $product['product_id'] }} | {{ $product['subscription_type'] }}
                        </button>

                        <div id="{{ $product['product_id'] }}" class="collapse" aria-expanded="false" aria-labelledby="{{ $product['product_id'] }}" data-parent="#aud">
                            <ul class="list-group">
                                @foreach($productInfo[$product['product_id']] as $value => $item)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-2"><strong><span
                                                        style="font-size: 14px">{{ $value }}</span></strong></div>
                                            @if($value === 'status')
                                                @if($item === 'active')
                                                    <div class="col-md-3"><span
                                                            style="color: green; font-size: 14px">{{ $item }}</span>
                                                    </div>
                                                @else
                                                    <div class="col-md-3"><span
                                                            style="color: red; font-size: 14px">{{ $item }}</span>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="col-md-3"><span style="font-size: 14px">{{ $item }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endforeach
            @else
                Not found
            @endif
        </ul>
    </div>
</tr>
<tr>
    <td>Batch Title</td>
    <td>{{ $batchInfo['title'] }}</td>
    <td></td>
</tr>
