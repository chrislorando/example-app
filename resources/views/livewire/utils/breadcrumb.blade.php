<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a wire:navigate href="{{ url('dashboard') }}">{{ __('Home') }}</a></li>
        @php($route = "")
        @foreach($breadCrumbs as $row)
            @php($route .= $row."/")
            <li @class(['breadcrumb-item'=>true, 'active'=> request()->is(rtrim($route,"/"))])>
                @if(request()->is(rtrim($route,"/")))
                {{ __(ucfirst($row)) }}
                @else
                    <a wire:navigate href="{{ url($route) }}" > {{ __(ucfirst($row)) }}</a>
                @endif
                
            </li>
        @endforeach
    </ol>
  </nav>

  