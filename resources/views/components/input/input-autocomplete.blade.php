@props(['data'])
@props(['name'])
@props(['value'])

<div x-data="{ query : '{{ $value }}', showData : true }">

    <input class="form-select" x-model="query" x-on:keyup="showData = true" {{ $attributes }}>

    {{-- @if($data)
    <ul class="list-group" x-show="showData">
        @foreach($data as $p)
            @if($value!=$p['value'])
            <a wire:click="$set('{{ $name }}', '{{ $p['value'] }}')" x-on:click="query = '{{ $p['text'] }}', showData = false" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" aria-current="true">
                {{ $p['text'] }}

                <i class="bi bi-plus"></i>
            </a>
            @endif
        @endforeach
    </ul>
    @endif --}}

    @if($data)
    <select class="form-select" size="4" aria-label="Select" x-show="showData">
        @foreach($data as $p)
            @if($value!=$p['value'])
            <option wire:click="$set('{{ $name }}', '{{ $p['value'] }}')" x-on:click="query = '{{ $p['text'] }}', showData = false">{{ $p['text'] }}</option>
            @endif
        @endforeach
    </select>
    @endif

    
</div>

@error($name)
    <span class="text-danger">
        <em>{{ __($message) }}</em> 
    </span>
@enderror