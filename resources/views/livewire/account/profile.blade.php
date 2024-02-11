@section('title')
{{ __('label.profile') }} 
@endsection

<div>
    
    <form class="row g-3 needs-validation" wire:submit="update">  
        @if ($photo_upload || $photo) 
            <div class="d-flex flex-column">
                <div class="p-2">
                    @if ($photo_upload) 
                        <img src="{{ $photo_upload->temporaryUrl() }}" class="rounded img-thumbnail" style="width: 150px;" alt="Avatar" >
                    @elseif ($photo) 
                        <img src="{{ asset($photo) }}" class="rounded img-thumbnail" style="width: 150px;" alt="Avatar" >
                    @endif
                </div>
                <div class="p-2">
                    @can($authorization['deletePhoto'])
                    <a href="#" wire:click.prevent="deletePhoto({{ $id }})" class="link-danger link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover icon-link icon-link-hover" style="--bs-link-hover-color-rgb: 25, 135, 84;"> 
                        Remove
                    </a>
                    @endcan
                </div>
            </div>
        @else
            <div class="d-flex flex-column">
                <div class="p-2">
                    <i class="bi bi-person-bounding-box display-1"></i>
                </div>
            </div>
        @endif

        {{-- <hr> --}}

        <h2 id="text-utilities">Personal</h2>
       
        <div class="mb-3 row">
            <label for="photo_upload" class="col-sm-3 col-form-label">{{ __('validation.attributes.photo') }}</label>
            <div class="col-sm-9">
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
        </div>

        <div class="mb-3 row">
            <label for="name" class="col-sm-3 col-form-label">{{ __('validation.attributes.name') }}</label>
            <div class="col-sm-9">
                <x-input.input-text type="text" id="name" name="name" placeholder="John Doe" wire:model="name" /> 
            </div>
        </div>

        <div class="mb-3 row">
            <label for="role_id" class="col-sm-3 col-form-label">{{ __('validation.attributes.role_id') }}</label>
            <div class="col-sm-9">
                <x-input.input-text type="text" id="role_id" name="narole_idme" placeholder="Admin" wire:model="role_id" disabled /> 
            </div>
        </div>

        <div class="mb-3 row">
            <label for="email" class="col-sm-3 col-form-label">{{ __('validation.attributes.email') }}</label>
            <div class="col-sm-9">
                <x-input.input-text type="email" id="email" name="email" placeholder="name@example.com" wire:model="email" />
            </div>
        </div>
      

        <div class="mb-3 mt-2 row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary "><i class="bi bi-floppy-fill"></i> {{ __('label.save') }}</button>
            </div>
        </div>

    </form>


    <hr>
    <form class="row g-3 needs-validation" wire:submit="updatePassword">  
    
        
        <h2 id="text-utilities">Account</h2>
    
        
        <div class="mb-3 row">
            <label for="username" class="col-sm-3 col-form-label">{{ __('validation.attributes.username') }}</label>
            <div class="col-sm-9">
                <x-input.input-text type="text" id="username" name="username" placeholder="" wire:model="username" disabled />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="password" class="col-sm-3 col-form-label">{{ __('validation.attributes.password') }}</label>
            <div class="col-sm-9">
                <x-input.input-text type="password" id="password" name="password" placeholder="********" wire:model="password" />
            </div>
        </div>

        <div class="mb-3 row">
            <label for="password_confirmation" class="col-sm-3 col-form-label">{{ __('validation.attributes.password_confirmation') }}</label>
            <div class="col-sm-9">
                <x-input.input-text type="password" id="password_confirmation" name="password_confirmation" placeholder="********" wire:model="password_confirmation" />
            </div>
        </div>

        <div class="mb-3 row">
            <div class="col-sm-9">
                <button type="submit" class="btn btn-primary "><i class="bi bi-floppy-fill"></i> {{ __('label.save') }}</button>
            </div>
        </div>

    </form>

    @if(session()->has('message') || session()->has('error'))
        <x-toast.alert />
    @endif
</div>

    
  