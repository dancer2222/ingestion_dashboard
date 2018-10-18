<div class="mb-3 border-bottom">
    <b>
        <a data-toggle="collapse" href="#{{$item->id}}_description" role="button" aria-expanded="false" aria-controls="{{$item->id}}_description">
            Description...
        </a>
    </b>
</div>

<div class="collapse mb-3" id="{{$item->id}}_description">
    {{ $item->description }}
</div>

<div class="mb-3 border-bottom">
    <b>ID:</b> <span class="float-right">{{ $item->id }}</span>
</div>