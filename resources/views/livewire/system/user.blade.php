@section('title')
{{ __('label.manage_user') }} 
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
        
        {{-- <div class="card-body"></div> --}}
    
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <x-table.table-heading column="" text="label.no" class="text-center" />
                        <x-table.table-heading column="" text="label.action" class="text-center" />
                        <x-table.table-heading column="" text="label.photo" class="text-center" />
                        <x-table.table-heading column="username" text="label.username" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="name" text="label.name" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="email" text="label.email" :sortField="$sortField" :sortDirection="$sortDirection" class="" />
                        <x-table.table-heading column="is_deleted" text="label.is_deleted" :sortField="$sortField" :sortDirection="$sortDirection" class="text-center" />
                    </tr>
                   
                </thead>
    
                <tbody>
                    @php($i=0)
                    @if(count($users) > 0)
                        @foreach($users as $key=>$row)
                            @php($i++)
                            @php($count = $users->firstItem() + $key)
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
                                    @can($authorization['show'])
                                        <button type="button" class="btn btn-info btn-sm" title="{{ __('label.view') }}" wire:loading.attr="disabled" wire:click="show({{ $row->id }})"><i class="bi bi-zoom-in"></i></button>
                                    @endcan
                                </td>
                                <td class="text-center">
                                    @if($row->photo)
                                        <img src="{{ asset($row->photo) }}" style="width: 50px;" class="rounded" alt="{{ $row->username }}">
                                    @else
                                        <i class="bi bi-person-bounding-box display-5"></i>
                                    @endif
                                </td>
                                <td>{{ $row->username }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
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
            <x-table.table-pagination :model="$users" perPageOpt="10,20,30,40,50" defaultPage="10" />
        </div>
    
    
        <!-- Modal Form -->
        @if ($isFormOpen)
        <div class="modal fade show" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog" style="display:block;" >
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ $isNewRecord ? __('label.create') : __('label.edit') }} {{ __('label.user') }}</h1>
                       
                        <div class="btn-group" role="group" aria-label="Basic outlined example">
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('minimize-modal')"><i class="bi bi-fullscreen-exit"></i></button>
                            <button type="button" class="btn btn-outline-secondary" wire:click="$dispatch('fullscreen-modal')"><i class="bi bi-fullscreen"></i></button>
                            <button type="button" class="btn btn-danger" wire:click="index"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" novalidate>  
                            @if ($photo_upload || $photo) 
                                <div class="d-flex flex-column">
                                    <div class="p-2">
                                        @if ($photo_upload) 
                                            <img src="{{ $photo_upload->temporaryUrl() }}" class="rounded img-thumbnail mx-auto d-block" style="width: 150px;" alt="Avatar" >
                                        @elseif ($photo) 
                                            <img src="{{ asset($photo) }}" class="rounded img-thumbnail mx-auto d-block" style="width: 150px;" alt="Avatar" >
                                        @endif
                                    </div>
                                    <div class="p-2 text-center">
                                        @can($authorization['deletePhoto'])
                                        <a href="#" wire:click.prevent="deletePhoto({{ $id }})" class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover icon-link icon-link-hover" style="--bs-link-hover-color-rgb: 25, 135, 84;"> 
                                            Remove
                                        </a>
                                        @endcan
                                    </div>
                                </div>
                            @else
                                <div class="d-flex flex-column text-center">
                                    <div class="p-2">
                                        <i class="bi bi-person-bounding-box display-1"></i>
                                    </div>
                                </div>
                            @endif
    
                            
                            <div class="mb-3">
                                <label for="photo_upload" class="form-label">{{ __('validation.attributes.photo') }}</label>
                          
                                <div
                                    x-data="{ uploading: false, progress: 0, }"
                                    x-on:livewire-upload-start="uploading = true"
                                    x-on:livewire-upload-finish="uploading = false"
                                    x-on:livewire-upload-error="uploading = false"
                                    x-on:livewire-upload-progress="progress = $event.detail.progress"
                                >
                                    <!-- File Input -->
                                    <input type="file" class="form-control" id="photo_upload" wire:model="photo_upload">
                            
                                    <div x-show="uploading" class="progress" role="progressbar" aria-label="Example 1px high" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 3px">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 100%"></div>
                                    </div>
                                </div>
                                @error('photo_upload')
                                    <span class="text-danger">
                                        <em>{{ __($message) }}</em> 
                                    </span>
                                @enderror
                            </div>
    
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('validation.attributes.name') }}</label>
                                <x-input.input-text type="text" id="name" name="name" placeholder="John Doe" wire:model="name" /> 
                             
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('validation.attributes.email') }}</label>
                                <x-input.input-text type="email" id="email" name="email" placeholder="name@example.com" wire:model="email" />
                            </div>
                            
                            <div class="mb-3">
                                <label for="username" class="form-label">{{ __('validation.attributes.username') }}</label>
                                <x-input.input-text type="text" id="username" name="username" placeholder="johndoe" wire:model="username" />
                            </div>
    
                            <div class="mb-3">
                                <label for="role_id" class="form-label">{{ __('validation.attributes.role_id') }}</label>
                                <x-input.input-select :data="$roles" id="role_id" name="role_id" placeholder="Role" wire:model="role_id" />
                            </div>
    
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('validation.attributes.password') }}</label>
                                <x-input.input-text type="password" id="password" name="password" placeholder="********" wire:model="password" />
                             
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">{{ __('validation.attributes.password_confirmation') }}</label>
                                <x-input.input-text type="password" id="password_confirmation" name="password_confirmation" placeholder="********" wire:model="password_confirmation" />
    
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
    
         <!-- Modal View -->
         @if ($isViewOpen)
         <div class="modal fade show" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog" style="display:block;" >
             <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h1 class="modal-title fs-5" id="staticBackdropLabel">View User</h1>
                         <button type="button" class="btn-close" wire:click="index"></button>
            
                     </div>
                     <div class="modal-body">
                        <div class="row  h-100">
                            <div class="col col-md-9 col-lg-7 col-xl-5">
                              <div class="card" style="border-radius: 15px;">
                                <div class="card-body p-4">
                                  <div class="d-flex text-black">
                                    <div class="flex-shrink-0">
                                      <img src="{{ $photo }}"
                                        alt="Generic placeholder image" class="img-fluid"
                                        style="width: 180px; border-radius: 10px;">
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                      <h5 class="mb-1">{{ $name }}</h5>
                                      <p class="mb-2 pb-1" style="color: #2b2a2a;">{{ $email }}</p>
                                      <div class="d-flex justify-content-start rounded-3 p-2 mb-2"
                                        style="background-color: #efefef;">
                                        <div>
                                          <p class="small text-muted mb-1">Articles</p>
                                          <p class="mb-0">41</p>
                                        </div>
                                        <div class="px-3">
                                          <p class="small text-muted mb-1">Followers</p>
                                          <p class="mb-0">976</p>
                                        </div>
                                        <div>
                                          <p class="small text-muted mb-1">Rating</p>
                                          <p class="mb-0">8.5</p>
                                        </div>
                                      </div>
                                      <div class="d-flex pt-1">
                                        <button type="button" class="btn btn-outline-primary me-1 flex-grow-1">Chat</button>
                                        <button type="button" class="btn btn-primary flex-grow-1">Follow</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
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