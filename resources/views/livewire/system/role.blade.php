@section('title')
{{ __('label.manage_role') }} 
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
                        <x-table.table-heading column="name" text="label.name" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="guard_name" text="label.guard_name" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="redirect" text="label.redirect" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="description" text="label.description" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="is_public" text="label.is_public" :sortField="$sortField" :sortDirection="$sortDirection" class="text-center" />
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
                                <td class="text-center">
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
                                    @can($authorization['show'])
                                        <button type="button" class="btn btn-info btn-sm" title="{{ __('label.show') }}" wire:loading.attr="disabled" wire:click="show({{ $row->id }})"><i class="bi bi-zoom-in"></i></button>
                                    @endcan
                                    @can($authorization['copy'])
                                        <button type="button" class="btn btn-secondary btn-sm" title="{{ __('label.copy') }}" wire:loading.attr="disabled" wire:click="copy({{ $row->id }})"><i class="bi bi-copy"></i></button>
                                    @endcan
                                
                                </td>
                           
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->guard_name }}</td>
                                <td>{{ $row->redirect }}</td>
                                <td>{{ $row->description }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{ $row->is_deleted==1 ? 'text-bg-danger' : 'text-bg-success'}}">{{ $row->getIsActiveText() }}</span>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">
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
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $isNewRecord ? __('label.create') : __('label.edit') }} {{ __('label.role') }}</h1>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('minimize-modal')"><i class="bi bi-fullscreen-exit"></i></button>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('fullscreen-modal')"><i class="bi bi-fullscreen"></i></button>
                            <button type="button" class="btn btn-danger" wire:click="index"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate>  
                          
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('validation.attributes.name') }}</label>
                                <x-input.input-text type="text" id="name" name="name" placeholder="admin" wire:model="name" /> 
                             
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('validation.attributes.guard_name') }}</label>
                                <x-input.input-text type="text" id="guard_name" name="guard_name" placeholder="web" wire:model="guard_name" />
                            </div>
                            
                            <div class="mb-3">
                                <label for="redirect" class="form-label">{{ __('validation.attributes.redirect') }}</label>
                                <x-input.input-text type="text" id="redirect" name="redirect" placeholder="/home" wire:model="redirect" />
                            </div>
    
                            <div class="mb-3">
                                <label for="description" class="form-label">{{ __('validation.attributes.description') }}</label>
                                <x-input.input-text type="text" id="description" name="description" placeholder="This is admin" wire:model="description" />
                            </div>
    
    
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $is_public==1 ? 0 : 1 }}" id="is_public" wire:model="is_public" {{ $is_public==1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_public">
                                        {{ __('validation.attributes.is_public') }}
                                    </label>
                                    @error('is_public')
                                        <span class="text-danger">
                                            <em>{{ __($message) }}</em> 
                                        </span>
                                    @enderror
                                </div>
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

        <!-- Modal View -->
        @if ($isViewOpen)
        <div class="modal fade show" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog" style="display:block;" >
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ __('label.show') }} {{ __('label.role') }}</h1>
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('minimize-modal')"><i class="bi bi-fullscreen-exit"></i></button>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('fullscreen-modal')"><i class="bi bi-fullscreen"></i></button>
                            <button type="button" class="btn btn-danger" wire:click="index"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tbody>
                              <tr>
                                <th style="width: 230px">{{ __('label.name') }}</th>
                                <td>{{ $name }}</td>
                              </tr>

                              <tr>
                                <th>{{ __('label.guard_name') }}</th>
                                <td>{{ $guard_name }}</td>
                              </tr>

                              <tr>
                                <th>{{ __('label.redirect') }}</th>
                                <td>{{ $redirect }}</td>
                              </tr>

                              <tr>
                                <th>{{ __('label.description') }}</th>
                                <td>{{ $description }}</td>
                              </tr>
                            </tbody>
                          </table>


                          <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 150px">Module</th>
                                    <th>Permissions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($rolePermissions as $key=>$rp)
                              <tr>
                                <th>{{ $key }}</th>
                                <td>
                                    @foreach($rp as $p)
                                       
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" value="" id="action_{{ $p['action'] }}" wire:click="permission({{ $id }}, {{ $p['id'] }})" {{ $p['can'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="action_{{ $p['action'] }}">
                                                {{ $p['action'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </td>
                              </tr>
                            @endforeach

                            </tbody>
                          </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="index"><i class="bi bi-x"></i> {{ __('label.close') }}</button>
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
