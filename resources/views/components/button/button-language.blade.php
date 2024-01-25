@props(['icon'])
@props(['class'])
@props(['data'])

<div>
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
        <i class="{{ $icon }}"></i>
    </a>

    <ul class="{{ $class }}">
        @foreach($data as $row)
          <li>
            <a @class(['active'=> session()->get('locale') == $row->code, 'dropdown-item'=>true]) wire:navigate href="{{ url('/language/'.$row->code) }}">
              @if($row->flag)
                <img src="{{ asset($row->flag) }}" height="22" width="22" class="pe-1">
              @endif
              {{ $row->name }}
            </a>
          </li>
        @endforeach
    </ul>
</div>