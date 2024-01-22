@props(['class'])
@props(['icon'])
@props(['text'])
@props(['action'])

<button type="submit" class="{{ $class }}" wire:click="{{ $action }}" wire:loading.attr="disabled">
    <i class="{{ $icon }}" wire:loading.class.remove="{{ $icon }}"></i> 
    <i wire:loading wire:target="{{ $action }}" class="spinner-border spinner-border-sm"></i>
    {{ __($text) }}
</button>
