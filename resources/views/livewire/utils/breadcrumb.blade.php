<nav aria-label="breadcrumb" class="d-print-none">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a wire:navigate href="{{ url('dashboard') }}">{{ __('label.home') }}</a></li>
        @php($route = "")
        @foreach($breadCrumbs as $row)
            @php($route .= $row."/")
            <li @class(['breadcrumb-item'=>true, 'active'=> request()->is(rtrim($route,"/"))])>
                @if(request()->is(rtrim($route,"/")))
                {{ __('label.'.strtolower($row)) }}
                @else
                    <a wire:navigate href="{{ url($route) }}" > {{ __('label.'.strtolower($row)) }}</a>
                @endif
                
            </li>
        @endforeach
    </ol>
  </nav>

  