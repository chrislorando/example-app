<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card">
                {{-- <div class="card-header bg-dark text-white"><i class="bi bi-shield-lock-fill"></i> {{ __('Login') }}</div> --}}

                <div class="card-body">
                    <form wire:submit="signin">
                        @csrf

                        @if (session()->has('message'))
                            <div class="alert alert-success">
                                {{ __(session('message')) }}
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ __(session('error')) }}
                            </div>
                        @endif

                        <ul class="list-inline">
  
                            <li class="nav-item dropdown list-inline-item">
                                <x-button.button-language :data="$languages" icon="bi bi-translate text-primary" class="dropdown-menu" />
                            </li>
                  
                            <li class="nav-item dropdown list-inline-item">
                                <x-button.button-theme class="dropdown-menu" />
                            </li>
                        </ul>

                        <div class="mb-3">
                            <label for="username" class="col-form-label">{{ __('validation.attributes.username') }}</label>

                            <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" wire:model="username" required autocomplete="username" autofocus>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ __($message) }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="col-form-label">{{ __('validation.attributes.password') }}</label>

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" wire:model="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ __($message) }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('label.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-0">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <div wire:loading.class="spinner-border spinner-border-sm"></div>
                                    {{ __('label.login') }} 
                                </button>

                                <a wire:navigate href="{{ route('register') }}" class="btn btn-outline-primary">
                                    {{ __('label.register') }} 
                                </a>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('label.forgot_password') }}
                                    </a>
                                @endif
                            
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>