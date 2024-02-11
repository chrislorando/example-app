<!doctype html>
<html lang="{{ app()->getLocale() }}" data-bs-theme="light">
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
  <div id="app position-relative">

      <livewire:utils.header />

      <livewire:utils.sidebar />

      <main id="mainContent" class="main-content">
          <div class="container-fluid d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center border-bottom">
              <h2> @yield('title') </h2>
              <livewire:utils.breadcrumb />
          </div>
          <div class="container-fluid mt-2">
      
            {{ $slot }}

            @if(session()->has('message') || session()->has('error'))
              <x-toast.alert />
            @endif
          </div>
      </main>
  </div>

  <div class="clearfix mb-5">&nbsp;</div>

  <livewire:utils.footer />

<script>

(() => {
  'use strict'

  const getStoredTheme = () => localStorage.getItem('theme')
  const setStoredTheme = theme => localStorage.setItem('theme', theme)

  const getPreferredTheme = () => {
    const storedTheme = getStoredTheme()
    if (storedTheme) {
      return storedTheme
    }

    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
  }

  const setTheme = theme => {
    if (theme === 'auto' && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      document.documentElement.setAttribute('data-bs-theme', 'dark')
    } else {
      document.documentElement.setAttribute('data-bs-theme', theme)
    }
  }

  setTheme(getPreferredTheme())

  const showActiveTheme = (theme, focus = false) => {
    const themeSwitcher = document.querySelector('#bd-theme')

    if (!themeSwitcher) {
      return
    }

    const activeThemeIcon = themeSwitcher.querySelector('i')
    const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`)
    const svgOfActiveBtn = btnToActive.querySelector('i').getAttribute('class')

    document.querySelectorAll('[data-bs-theme-value]').forEach(element => {
      element.classList.remove('active')
      element.setAttribute('aria-pressed', 'false')
    })

    btnToActive.classList.add('active')
    btnToActive.setAttribute('aria-pressed', 'true')
    activeThemeIcon.setAttribute('class', svgOfActiveBtn)

    if (focus) {
      themeSwitcher.focus()
    }
  }

  window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    const storedTheme = getStoredTheme();
    if (storedTheme !== 'light' && storedTheme !== 'dark') {
      setTheme(getPreferredTheme())
    }
  });

  const getStoredOffCanvas = () => localStorage.getItem('offcanvas');
  const setStoredOffCanvas = show => localStorage.setItem('offcanvas', show);

  const showOffCanvas = show => {
    const myOffcanvas = document.getElementById('sidebarMenu');
    if(myOffcanvas){

      if (show == true) {
        console.log('SIDEBAR ON', show);
        
        myOffcanvas.classList.add('show');
        document.getElementById('mainHeader').classList.remove('full-expand');
        document.getElementById('mainContent').classList.remove('full-expand');
        document.getElementById('mainFooter').classList.remove('full-expand');
        document.getElementById('mainHeader').classList.add('sidebar-expand');
        document.getElementById('mainContent').classList.add('sidebar-expand');
        document.getElementById('mainFooter').classList.add('sidebar-expand');
        document.getElementById('showSidebar').classList.add('visually-hidden');
      
      } else {
        console.log('SIDEBAR ON', show);
        myOffcanvas.classList.remove('show');
        document.getElementById('mainHeader').classList.add('full-expand');
        document.getElementById('mainContent').classList.add('full-expand');
        document.getElementById('mainFooter').classList.add('full-expand');
        document.getElementById('showSidebar').classList.remove('visually-hidden');

      }
    }
  }

  window.addEventListener('livewire:navigated', () => {

    showActiveTheme(getPreferredTheme());

    document.querySelectorAll('[data-bs-theme-value]')
      .forEach(toggle => {
        toggle.addEventListener('click', () => {
          const theme = toggle.getAttribute('data-bs-theme-value')
          setStoredTheme(theme)
          setTheme(theme)
          showActiveTheme(theme, true)
      })
    });

    showOffCanvas(true);
    
    const storedOffCanvas = getStoredOffCanvas();
    console.log('STORED OC',storedOffCanvas)
    if(storedOffCanvas=='true'){
      showOffCanvas(true);
    }else{
      showOffCanvas(false);
    }
 
    const hide = document.getElementById('hideSidebar');
    if(hide){
      hide.addEventListener('click', () => {
        setStoredOffCanvas(false);
        showOffCanvas(false);
      })
    }
  

    const show = document.getElementById('showSidebar');
    if(show){
      show.addEventListener('click', () => {
        setStoredOffCanvas(true);
        showOffCanvas(true);
      })
    }

  })
})()


   window.addEventListener("resize", function() {
    
    const mq768 = window.matchMedia( "(max-width: 768px)" );
    if (mq768.matches) {
      
      document.getElementById('sidebarMenu').classList.remove('show');
      document.getElementById('sidebarMenu').classList.add('full-sidebar');
      document.getElementById('mainHeader').classList.add('full-expand');
      document.getElementById('mainContent').classList.add('full-expand');
      document.getElementById('mainFooter').classList.add('full-expand');
      document.getElementById('showSidebar').classList.remove('visually-hidden');
    } else {
      document.getElementById('sidebarMenu').classList.add('show');
      document.getElementById('sidebarMenu').classList.remove('full-sidebar');
      document.getElementById('mainHeader').classList.remove('full-expand');
      document.getElementById('mainContent').classList.remove('full-expand');
      document.getElementById('mainFooter').classList.remove('full-expand');
      document.getElementById('showSidebar').classList.add('visually-hidden');
    }
  
  });

  document.addEventListener('livewire:init', () => {
  
       Livewire.on('open-modal', (event) => {
          document.body.classList.add("modal-open");
          document.getElementsByTagName('body')[0].style = 'overflow: hidden; padding-right: 15px;';

          var myDiv = document.createElement("div");
          myDiv.id='backdrop';
          myDiv.classList.add('modal-backdrop','fade','show');
          document.body.appendChild(myDiv);
       });

       Livewire.on('close-modal', (event) => {
        
        document.getElementById('staticBackdrop').classList.remove('show');
        document.getElementById('staticBackdrop').style.display="none";
          document.body.classList.remove("modal-open");
          document.getElementsByTagName('body')[0].style = '';
        
          document.getElementById('backdrop').classList.remove('modal-backdrop','fade','show');
          var div = document.getElementById('backdrop');
          if (div) {
              div.remove();
          }
       });

       Livewire.on('minimize-modal', (event) => {
          document.getElementById('staticBackdrop').getElementsByClassName("modal-dialog")[0].classList.remove('modal-fullscreen');
       });

       Livewire.on('fullscreen-modal', (event) => {
          document.getElementById('staticBackdrop').getElementsByClassName("modal-dialog")[0].classList.add('modal-fullscreen');
       });
       
    });




</script>

</body>
</html>
