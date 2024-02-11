@section('title')
{{ __('label.manage_menu') }} 
@endsection

<div>
    <div class="d-flex flex-wrap gap-3 pt-2">
        <div class="">
            @can($authorization['create'])
                <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="create"><i class="bi bi-plus-lg"></i> {{ __('label.create') }}</button>
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
                        <x-table.table-heading column="icon" text="label.icon" :sortField="$sortField" :sortDirection="$sortDirection" class="text-center" />
                        <x-table.table-heading column="sequence" text="label.sequence" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="parent_id" text="label.group" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="code" text="label.code" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="name" text="label.name" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="translate" text="label.translate" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="url" text="label.url" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="description" text="label.description" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="position" text="label.position" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="is_deleted" text="label.is_deleted" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
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
                                        <button type="button" class="btn btn-sm btn-danger" title="{{ __('label.delete') }}" wire:loading.attr="disabled" wire:click="delete({{ $row->id }})" wire:confirm="{{ $row->trashed() ? __('confirm.force_delete', ['name' => $row->name]) : __('confirm.delete', ['name' => $row->name]) }}"><i class="bi bi-trash3-fill"></i></button>
                                    @endcan
                                    @can($authorization['restore'])
                                        @if($row->trashed())
                                            <button type="button" class="btn btn-success btn-sm" title="{{ __('label.restore') }}" wire:loading.attr="disabled" wire:click="restore({{ $row->id }})" wire:confirm="{{ __('confirm.restore', ['name' => $row->name]) }}"><i class="bi bi-arrow-counterclockwise"></i></button>
                                        @endif
                                    @endcan
                                    @can($authorization['edit'])
                                        <button type="button" class="btn btn-warning btn-sm" title="{{ __('label.edit') }}" wire:loading.attr="disabled" wire:click="edit({{ $row->id }})"><i class="bi bi-pencil-square"></i></button>
                                    @endcan
                                
                                </td>
                           
                                <td class="text-center"><i class="{{ $row->icon }}"></i></td>
                                <td>{{ $row->sequence }}</td>
                                <td>{{ isset($row->parent) ? $row->parent->name : '' }}</td>
                                <td>{{ $row->code }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->translate }}</td>
                                <td>{{ $row->url }}</td>
                                <td>{{ $row->description }}</td>
                                <td>{{ $row->getPositionText() }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $row->is_deleted==1 ? 'text-bg-danger' : 'text-bg-success'}}">{{ $row->getIsActiveText() }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="12" class="text-center">
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
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $isNewRecord ? __('label.create') : __('label.edit') }} {{ __('label.menu') }}</h1>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('minimize-modal')"><i class="bi bi-fullscreen-exit"></i></button>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('fullscreen-modal')"><i class="bi bi-fullscreen"></i></button>
                            <button type="button" class="btn btn-danger" wire:click="index"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate>  
                          
                            <div class="mb-3">
                                <label for="sequence" class="form-label">{{ __('validation.attributes.sequence') }}</label>
                                <x-input.input-text type="text" id="sequence" name="sequence" placeholder="1" wire:model="sequence" />
                            </div>

                            <div class="mb-3">
                                <label for="icon" class="form-label">{{ __('validation.attributes.icon') }}</label>

                                <div class="input-group">
                                    <x-input.input-text type="text" id="icon" name="icon" placeholder="bi bi-arrow-clockwise" wire:model.live="icon" /> 
                                    <span class="input-group-text" id="basic-addon2"><i class="{{ $icon }}"></i></span>
                                </div>

                                <div class="form-text" id="basic-addon4"><a href="https://icons.getbootstrap.com/" target="_blank">Please refer to https://icons.getbootstrap.com/</a></div>
                            </div>

                            <div class="mb-3">
                                <label for="parent_id" class="form-label">{{ __('validation.attributes.group') }}</label>
                                <x-input.input-select :data="$optionsMenu" id="parent_id" name="parent_id" placeholder="{{ __('group') }}" wire:model="parent_id" />
                            </div>

                            <div class="mb-3">
                                <label for="code" class="form-label">{{ __('validation.attributes.code') }}</label>
                                <x-input.input-text type="text" id="code" name="code" placeholder="B0123" wire:model="code" /> 
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('validation.attributes.name') }}</label>
                                <x-input.input-text type="text" id="name" name="name" placeholder="system.controller.action" wire:model="name" /> 
                            </div>
                            
                            <div class="mb-3">
                                <label for="translate" class="form-label">{{ __('validation.attributes.translate') }}</label>
                                <x-input.input-text type="text" id="translate" name="translate" placeholder="label.translate" wire:model="translate" />
                            </div>

                            <div class="mb-3">
                                <label for="url" class="form-label">{{ __('validation.attributes.url') }}</label>
                                <x-input.input-autocomplete type="text" id="url" name="url" placeholder="{{ __('label.type_search') }}" :value="$url" :text="$url" :data="$optionsPermission" wire:model.live="url_q" />                             
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('label.description') }}</label>
                                <x-input.input-text type="text" id="description" name="description" placeholder="This is admin" wire:model="description" />
                            </div>

                            <div class="mb-3">
                                <label for="position" class="form-label">{{ __('validation.attributes.position') }}</label>
                                <x-input.input-select :data="[['value'=>0, 'text'=>'Header'], ['value'=>1, 'text'=>'Sidebar']]" id="position" name="position" placeholder="{{ __('position') }}" wire:model="position" />
                            </div>

                            {{-- <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $is_deleted==1 ? 0 : 1 }}" id="is_deleted" wire:model="is_deleted" {{ $is_deleted==1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_deleted">
                                        {{ __('label.is_deleted') }}
                                    </label>
                                    @error('is_deleted')
                                        <span class="text-danger">
                                            <em>{{ __($message) }}</em> 
                                        </span>
                                    @enderror
                                </div>
                            </div> --}}
    

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

