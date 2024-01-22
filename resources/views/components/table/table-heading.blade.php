<th scope="col" class="{{ $class }} text-nowrap">
    {{ __($text) }} 
    @if($column!='')
    <a wire:loading.attr="disabled" wire:click.prevent="sort('{{ $column }}')" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover" href="#">
        @if($sortField==$column && $sortDirection=='asc')
            <i class="bi bi-sort-up-alt"></i>
        @elseif($sortField==$column && $sortDirection=='desc')
            <i class="bi bi-sort-down"></i>
        @else
            <i class="bi bi-arrow-down-up"></i>
        @endif
    </a>
    @endif
</th>