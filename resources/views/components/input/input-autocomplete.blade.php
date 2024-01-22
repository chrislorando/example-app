@props(['data'])
@props(['name'])
@props(['value'])


<div x-data="{ query : '{{ $value }}', showData : true }">

    <input class="form-select" x-model="query" x-on:keyup="showData = true" {{ $attributes }}>

    @if($data)
    <ul class="list-group" x-show="showData">
        @foreach($data as $p)
            @if($value!=$p['text'])
            <a wire:click="$set('{{ $name }}', '{{ $p['text'] }}')" x-on:click="query = '{{ $p['text'] }}', showData = false" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" aria-current="true">
                {{ $p['text'] }}

                <i class="bi bi-plus"></i>
            </a>
            @endif
        @endforeach
    </ul>
    @endif
</div>

@error($name)
    <span class="text-danger">
        <em>{{ __($message) }}</em> 
    </span>
@enderror