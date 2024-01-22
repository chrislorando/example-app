@props(['type'])
@props(['id'])
@props(['name'])
@props(['placeholder'])

<input class="form-control" type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" placeholder="{{ $placeholder ? $placeholder : '' }}" {{ $attributes }}>
@error($name)
    <span class="text-danger">
        <em>{{ __($message) }}</em> 
    </span>
@enderror