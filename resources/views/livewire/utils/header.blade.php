<nav id="mainHeader" class="main-header navbar navbar-expand-lg shadow-sm fixed-top bg-body-tertiary" aria-label="Tenth navbar example">
  <div class="container-fluid">

      <button id="showSidebar" class="offcanvas-toggler nav-link px-3 visually-hidden" type="button" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <i class="bi bi-caret-right-fill"></i>
      </button>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#headerMenu" aria-controls="headerMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      

      <div class="collapse navbar-collapse" id="headerMenu">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          @foreach($models as $row)
            @if($row->parent==null && count($row->children->where('position','0'))==0)
              <li class="nav-item">
                <a @class(['active'=> request()->is($row->url), 'nav-link'=>true]) wire:navigate href="{{ url($row->url) }}">
                  <i class="{{ $row->icon }}"></i>
                  {{ $row->translate ? __($row->translate) : $row->name }} 
                </a>
              </li>
            @else
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    <i class="{{ $row->icon }}"></i> {{ $row->translate ? __($row->translate) : $row->name }} 
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    @foreach($row->children->where('position','0') as $r)
                      <li>
                        <a @class(['active'=> request()->is($r->url), 'dropdown-item'=>true]) wire:navigate href="{{ url($r->url) }}">
                          <i class="{{ $r->icon }}"></i>
                          {{ $r->translate ? __($r->translate) : $r->name }}
                        </a>
                      </li>
                    @endforeach
                </ul>
              </li>
            @endif
          @endforeach
        </ul>

        <ul class="navbar-nav ms-auto">
  
          <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  <i class="bi bi-translate text-primary"></i>
              </a>

              <ul class="dropdown-menu dropdown-menu-end">
                  @foreach($languages as $l)
                    <li>
                      <a class="dropdown-item" wire:navigate href="{{ url('/language/'.$l->code) }}">
                        @if($l->flag)
                          <img src="{{ asset($l->flag) }}" height="22" width="22" class="pe-1">
                        @endif
                        {{ $l->name }}
                      </a>
                    </li>
                  @endforeach
              </ul>
          </li>

          <li class="nav-item dropdown">
            <a id="bd-theme" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              <i class="bi bi-brightness-high-fill text-warning"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <button type="button" class="dropdown-item" data-bs-theme-value="light" aria-pressed="false">
                    <i class="bi bi-brightness-high-fill text-warning"></i>
                    {{ __('label.light') }}
                  </button>
                
                </li>
                <li>
                  <button type="button" class="dropdown-item" data-bs-theme-value="dark" aria-pressed="false">
                    <i class="bi bi-moon-stars-fill me-1"></i>
                    {{ __('label.dark') }}
                  </button>
                </li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                <i class="bi bi-person-circle"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
              <li>
                <a class="dropdown-item" href="#">
                  {{ Auth::user()->name }} 
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                  <i class="bi bi-power text-danger"></i>
                    {{ __('label.logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
              </li>
            </ul>
            
          </li>
         
        </ul>
    </div>
  </div>
</nav>