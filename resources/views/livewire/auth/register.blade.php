<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                {{-- <div class="card-header bg-dark text-white"><i class="bi bi-shield-lock-fill"></i> {{ __('Login') }}</div> --}}

                <div class="card-body">
                    <form wire:submit="save">
                        @csrf

                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ session('message') }}
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="name" class="col-form-label">{{ __('validation.attributes.name') }}</label>

                            <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" wire:model="name" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="col-form-label">{{ __('validation.attributes.email') }}</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" wire:model="email" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="col-form-label">{{ __('validation.attributes.password') }}</label>

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" wire:model="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="col-form-label">{{ __('validation.attributes.password_confirmation') }}</label>

                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" wire:model="password_confirmation" required>

                            @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="mb-0">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <div wire:loading.class="spinner-border spinner-border-sm"></div>
                                    {{ __('label.register') }} 
                                </button>

                                <a wire:navigate class="btn btn-link" href="{{ route('login') }}">
                                    {{ __('label.already_register') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>