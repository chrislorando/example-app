<div class="d-flex">
    @php
    $pages = explode(",", $perPageOpt);
    @endphp
    <div class="p-2 flex-grow-1"> {{ $model->onEachSide(5)->links() }}</div>
  
    <div class="p-2 d-none d-md-block d-sm-none pt-3"><p class="align-bottom">Showing {{ $model->firstItem() }} to {{ $model->lastItem() }} of {{ $model->total() }} entries</p></div>
    <div class="p-2">
        <select class="form-select col-lg-1" title="Per Page" wire:model.live.debounce.350ms="perPage">
            @foreach($pages as $p)
                <option value="{{ $p }}" {{ $defaultPage==$p ? 'selected' : '' }}>{{ $p }}</option>
            @endforeach
        </select>
    </div>
</div>