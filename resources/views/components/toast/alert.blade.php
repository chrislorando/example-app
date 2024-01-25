<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header">
            @if(session()->has('message'))
                <i class="bi bi-check-square-fill text-success pe-2"></i>
                <strong class="me-auto text-success">{{ __('label.message') }}</strong>
            @elseif(session()->has('error'))
                <i class="bi bi-x-square-fill text-danger pe-2"></i>
                <strong class="me-auto text-danger">{{ __('label.message') }}</strong>
            @else
                <i class="bi bi-info-square-fill text-info pe-2"></i>
                <strong class="me-auto text-info">{{ __('label.message') }}</strong>
            @endif
        
            
            {{-- <small>11 mins ago</small> --}}
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        
        @if (session()->has('message'))
            <div class="toast-body text-success">
                {{ session('message') }}
            </div>
        @elseif(session()->has('error'))
            <div class="toast-body text-danger">
                {{ session('error') }}
            </div>
        @endif
       
    </div>
</div>