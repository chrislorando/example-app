@section('title')
{{ __('label.manage_permission') }} 
@endsection

<div>
    <div class="d-flex flex-wrap gap-3 pt-2">
        <div class="">
            @can($authorization['create'])
                <button type="button" class="btn btn-primary" wire:loading.attr="disabled" wire:click="create"><i class="bi bi-plus-lg"></i> {{ __('label.create') }}</button>
            @endcan

            @can($authorization['generate'])
                <x-button.button-submit class="btn btn-danger" icon="bi bi-recycle" text="label.generate" action="generate" />
            @endcan
            
        </div>
        <div class="ms-auto">
            <form wire:submit="search">
                <div class="input-group mb-3">
                
                      <input type="text" class="form-control" placeholder="{{ __('label.search') }}..." aria-label="Search" wire:model="q">

                    <button class="btn btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
                    <button class="btn btn-primary" type="button" wire:click="$refresh"><i class="bi bi-arrow-clockwise"></i></button>
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
                        <x-table.table-heading column="guard_name" text="label.guard_name" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="name" text="label.name" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="controller" text="label.controller" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="action" text="label.action" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="alias" text="label.alias" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="description" text="label.description" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
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
                                        <button type="button" class="btn btn-sm btn-danger" title="{{ __('label.delete') }}" wire:loading.attr="disabled" wire:click="delete({{ $row->id }})" wire:confirm="{{ __('confirm.delete', ['name' => $row->name]) }}"><i class="bi bi-trash3-fill"></i></button>
                                    @endcan
                                    @can($authorization['edit'])
                                        <button type="button" class="btn btn-warning btn-sm" title="{{ __('label.edit') }}" wire:loading.attr="disabled" wire:click="edit({{ $row->id }})"><i class="bi bi-pencil-square"></i></button>
                                    @endcan
                                
                                </td>
                           
                                <td>{{ $row->guard_name }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->controller }}</td>
                                <td>{{ $row->action }}</td>
                                <td>{{ $row->alias }}</td>
                                <td>{{ $row->description }}</td>
                            
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
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $isNewRecord ? __('label.create') : __('label.edit') }} {{ __('label.permission') }}</h1>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('minimize-modal')"><i class="bi bi-fullscreen-exit"></i></button>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('fullscreen-modal')"><i class="bi bi-fullscreen"></i></button>
                            <button type="button" class="btn btn-danger" wire:click="index"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate>  
                          
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('validation.attributes.guard_name') }}</label>
                                <x-input.input-text type="text" id="guard_name" name="guard_name" placeholder="web" wire:model="guard_name" />
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('validation.attributes.name') }}</label>
                                <x-input.input-text type="text" id="name" name="name" placeholder="system.controller.action" wire:model="name" /> 
                            </div>
                            
                            <div class="mb-3">
                                <label for="controller" class="form-label">{{ __('validation.attributes.controller') }}</label>
                                <x-input.input-text type="text" id="controller" name="controller" placeholder="Default" wire:model="controller" />
                            </div>

                            <div class="mb-3">
                                <label for="action" class="form-label">{{ __('validation.attributes.action') }}</label>
                                <x-input.input-text type="text" id="action" name="action" placeholder="index" wire:model="action" />
                            </div>

                            <div class="mb-3">
                                <label for="alias" class="form-label">{{ __('validation.attributes.alias') }}</label>
                                <x-input.input-text type="text" id="alias" name="alias" placeholder="default/action" wire:model="alias" />
                            </div>
    
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('validation.attributes.description') }}</label>
                                <x-input.input-text type="text" id="description" name="description" placeholder="This is admin" wire:model="description" />
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
