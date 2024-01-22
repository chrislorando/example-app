<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | {{ $title ?? 'Page Title' }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
   
</head>
<body class="antialiased">
    
    <div id="app">

       

        {{-- <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">

            <a href="{{ url('/') }}" class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white">
                <img src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="30" height="24" class="d-inline-block align-text-top">
                {{ config('app.name', 'Laravel') }}
            </a>

            <ul class="navbar-nav flex-row d-md-none">
              <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSearch" aria-controls="navbarSearch" aria-expanded="false" aria-label="Toggle search">
                  <svg class="bi"><use xlink:href="#search"></use></svg>
                </button>
              </li>
              <li class="nav-item text-nowrap">
                <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                  <i class="bi bi-list"></i>
                </button>
              </li>
            </ul>
          
            <div id="navbarSearch" class="navbar-search w-100 collapse">
              <input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
            </div>
        </header> --}}

        <div class="container-fluid">
            <livewire:utils.header />
           
            <div class="row">
                {{-- <div class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                    <livewire:utils.sidebar />
                </div> --}}

                <div class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
                    <div class="offcanvas-md offcanvas-start bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel" data-bs-scroll="true">
                      <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="sidebarMenuLabel">Company name</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
                      </div>
                      <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">

                        
                        <div class="accordion accordion-flush show" id="accordionExample">
                            <div class="list-group list-group-flush border-bottom px-1">
                                <a data-bs-toggle="collapse" @class(['active'=> request()->is('system/user'), 'list-group-item list-group-item-action d-flex justify-content-between align-items-start'=>true]) aria-current="true" wire:navigate href="{{ url('system/user') }}">
                                    <div class="fw-bold">{{ __('label.user') }}</div>
                                    <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="User Module"></i>
                                </a>
                            </div>
                    
                            <div class="accordion-item">
                       
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        <div class="fw-bold">Module One</div>
                                    </button>
                                </h2>
                    
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" >
                                    <div class="list-group list-group-flush">
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start " aria-current="true">
                                            Link One
                                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Hover over the buttons below to see the four tooltips directions: top, right, bottom, and left. Directions are mirrored when using Bootstrap in RTL."></i>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" aria-current="true">
                                            Link Two
                                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Hover over the buttons below to see the four tooltips directions: top, right, bottom, and left. Directions are mirrored when using Bootstrap in RTL."></i>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" aria-current="true">
                                            Link Three
                                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Hover over the buttons below to see the four tooltips directions: top, right, bottom, and left. Directions are mirrored when using Bootstrap in RTL."></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <div class="fw-bold">Module Two</div>
                                </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" >
                                    <div class="list-group list-group-flush">
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" aria-current="true">
                                            Link One
                                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Hover over the buttons below to see the four tooltips directions: top, right, bottom, and left. Directions are mirrored when using Bootstrap in RTL."></i>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" aria-current="true">
                                            Link Two
                                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Hover over the buttons below to see the four tooltips directions: top, right, bottom, and left. Directions are mirrored when using Bootstrap in RTL."></i>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" aria-current="true">
                                            Link Three
                                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Hover over the buttons below to see the four tooltips directions: top, right, bottom, and left. Directions are mirrored when using Bootstrap in RTL."></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <div class="fw-bold">Module Two</div>
                                </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" >
                                    <div class="list-group list-group-flush">
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" aria-current="true">
                                            Link One
                                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Hover over the buttons below to see the four tooltips directions: top, right, bottom, and left. Directions are mirrored when using Bootstrap in RTL."></i>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" aria-current="true">
                                            Link Two
                                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Hover over the buttons below to see the four tooltips directions: top, right, bottom, and left. Directions are mirrored when using Bootstrap in RTL."></i>
                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-start" aria-current="true">
                                            Link Three
                                            <i class="bi bi-info-circle-fill text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Hover over the buttons below to see the four tooltips directions: top, right, bottom, and left. Directions are mirrored when using Bootstrap in RTL."></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        
                
                        </div>
                        
                       
                      </div>
                    </div>
                  </div>

                {{-- <div class="clearfix d-xl-none d-lg-none d-md-none">&nbsp;</div> --}}

                <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 h-100">
                    
                        {{ $slot }}
                    
                       
                        {{-- <footer class="footer bg-light">
                            <div class="row g-0 justify-content-between fs-10 mt-4 mb-3">
                              <div class="col-12 col-sm-auto text-center">
                                <p class="mb-0 text-600">Thank you for creating with Falcon <span class="d-none d-sm-inline-block">| </span><br class="d-sm-none"> 2023 © <a href="https://themewagon.com">Themewagon</a></p>
                              </div>
                              <div class="col-12 col-sm-auto text-center">
                                <p class="mb-0 text-600">v3.19.0</p>
                              </div>
                            </div>
                        </footer> --}}
                        {{-- <livewire:utils.footer /> --}}
                </main>

      
            </div>

        </div>
    </div>

    {{-- <div class="clearfix mb-5">&nbsp;</div> --}}

    {{-- <livewire:utils.footer /> --}}

   
    @if(session()->has('message') || session()->has('error'))
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" @class(['toast show text-bg-success'=> session()->has('message'), 'toast show text-bg-danger'=> session()->has('error')]) role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <strong class="me-auto">{{ __('label.message') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
          </div>
          <div class="toast-body">
            @if (session()->has('message'))
                {{ session('message') }}
            @endif
            @if (session()->has('error'))
                {{ session('error') }}
            @endif
          </div>
        </div>
      </div>
      @endif
</body>
</html>
