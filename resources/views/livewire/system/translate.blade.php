@section('title')
{{ __('label.manage_translate') }} 
@endsection

<div>
    <div class="d-flex flex-wrap pt-2">
        <div class="grid gap-0 column-gap-3">
            @can($authorization['create'])
                <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="create"><i class="bi bi-plus-lg"></i> {{ __('label.create') }}</button>
            @endcan

            @can($authorization['publish'])
                <button type="button" class="btn btn-success" wire:loading.attr="disabled" wire:click="publish"><i class="bi bi-file-earmark-arrow-up-fill"></i> {{ __('label.publish') }}</button>
            @endcan

            @can($authorization['backup'])
                <button type="button" class="btn btn-secondary" wire:loading.attr="disabled" wire:click="backup"><i class="bi bi-database-fill-down"></i> {{ __('label.backup') }}</button>
            @endcan
            
        </div>
        <div class="ms-auto">
            <form wire:submit="search">
                <div class="input-group mb-3">
                    <select class="form-select" aria-label="Default select example" wire:model.blur="is_deleted_q">
                        <option value="" selected>All</option>
                        <option value="0">Active</option>
                        <option value="1">Deleted</option>
                    </select>
                    <input type="text" class="form-control" placeholder="{{ __('label.search') }}..." aria-label="Search" wire:model="q">

                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    <button class="btn btn-primary" type="button" wire:click="$refresh"><i class="bi bi-arrow-repeat"></i></button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <a href="#">
                <i class="bi bi-file-earmark-spreadsheet-fill text-success"></i> {{ __('label.download') }}
            </a>
            
            <div wire:loading class="spinner-border spinner-border-sm float-end" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    
    
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <x-table.table-heading column="" text="label.no" class="text-center" />
                        <x-table.table-heading column="" text="label.action" class="text-center" />
                        <x-table.table-heading column="locale" text="label.locale" class="text-center" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="group" text="label.group" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="parent" text="label.parent" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="code" text="label.code" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="value" text="label.value" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="is_deleted" text="label.is_deleted" :sortField="$sortField" :sortDirection="$sortDirection" class="text-center" />
                    </tr>
                   
                </thead>
    
                <tbody>
                    @php($i=0)
                    @if(count($models) > 0)
                        @foreach($models as $key=>$row)
                            @php($i++)
                            @php($count = $models->firstItem() + $key)
                            <tr>
                                <th scope="row" class="text-center">{{ $count }}</th>
                                <td class="text-nowrap text-center">
                                    @can($authorization['delete'])
                                        <button type="button" class="btn btn-sm btn-danger" title="{{ __('label.delete') }}" wire:loading.attr="disabled" wire:click="delete({{ $row->id }})" wire:confirm="{{ $row->trashed() ? __('confirm.force_delete', ['name' => $row->locale.' - '.$row->group.' - '.$row->code]) : __('confirm.delete', ['name' => $row->locale.' - '.$row->group.' - '.$row->code]) }}"><i class="bi bi-trash3-fill"></i></button>
                                    @endcan
                                    @can($authorization['restore'])
                                        @if($row->trashed())
                                            <button type="button" class="btn btn-success btn-sm" title="{{ __('label.restore') }}" wire:loading.attr="disabled" wire:click="restore({{ $row->id }})" wire:confirm="{{ __('confirm.restore', ['name' => $row->locale.' - '.$row->group.' - '.$row->code]) }}"><i class="bi bi-arrow-counterclockwise"></i></button>
                                        @endif
                                    @endcan
                                    @can($authorization['edit'])
                                        <button type="button" class="btn btn-warning btn-sm" title="{{ __('label.edit') }}" wire:loading.attr="disabled" wire:click="edit({{ $row->id }})"><i class="bi bi-pencil-square"></i></button>
                                    @endcan
                                  
                                </td>
                             
                                <td>{{ $row->locale }}</td>
                                <td>{{ $row->group }}</td>
                                <td>{{ $row->parent }}</td>
                                <td>{{ $row->code }}</td>
                                <td>{{ $row->value }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $row->is_deleted==1 ? 'text-bg-danger' : 'text-bg-success'}}">{{ $row->getIsActiveText() }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="8" class="text-center">
                                {{ __('label.data_not_found') }}
                            </td>
                        </tr>
                    @endif
                </tbody>
                
            </table>
        </div>
    
        
        <div class="card-footer">
            <x-table.table-pagination :model="$models" perPageOpt="10,20,30,40,50" defaultPage="10" />
        </div>
    
    
        <!-- Modal Form -->
        @if ($isFormOpen)
        <div class="modal fade show" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog" style="display:block;" >
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $isNewRecord ? __('label.create') : __('label.edit') }} {{ __('label.translate') }}</h1>
                       
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('minimize-modal')"><i class="bi bi-fullscreen-exit"></i></button>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('fullscreen-modal')"><i class="bi bi-fullscreen"></i></button>
                            <button type="button" class="btn btn-danger" wire:click="index"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate>  
                          
                            <div class="mb-3">
                                <label for="locale" class="form-label">{{ __('validation.attributes.locale') }}</label>
                                <x-input.input-select :data="$countries" id="locale" name="locale" placeholder="en" wire:model="locale" />
                            </div>

                            <div class="mb-3">
                                <label for="code" class="form-label">{{ __('validation.attributes.group') }}</label>
                                <x-input.input-text type="text" id="group" name="group" placeholder="label" wire:model="group" /> 
                            </div>

                            <div class="mb-3">
                                <label for="parent" class="form-label">{{ __('validation.attributes.parent') }}</label>
                                <x-input.input-text type="text" id="parent" name="parent" placeholder="hello" wire:model="parent" /> 
                            </div>

                            <div class="mb-3">
                                <label for="code" class="form-label">{{ __('validation.attributes.code') }}</label>
                                <x-input.input-text type="text" id="code" name="code" placeholder="hello" wire:model="code" /> 
                            </div>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('validation.attributes.value') }}</label>
                                <x-input.input-text type="text" id="value" name="value" placeholder="halo" wire:model="value" />
                            </div>
    
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="index"><i class="bi bi-x"></i> {{ __('label.close') }}</button>
                        @if($isNewRecord)
                            <x-button.button-submit class="btn btn-primary" icon="bi bi-floppy-fill" text="label.save" action="store" />
                        @else
                            <x-button.button-submit class="btn btn-primary" icon="bi bi-floppy-fill" text="label.save" action="update" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

    
        @if(session()->has('message') || session()->has('error'))
            <x-toast.alert />
        @endif
    
    </div>
</div>