<div>
    <input wire:model.live="data" />
    {{-- <input class="form-control" type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder ? $placeholder : '' }}" {{ $attributes }}> --}}
    {{ json_encode($data) }}
    {{-- <ul class="list-group">
        @foreach($data as $p)
            <a href="{{ $p['text'] }}" class="list-group-item list-group-item-action" aria-current="true">
                {{ $p['text'] }}
            </a>
        @endforeach
    </ul> --}}
</div>
