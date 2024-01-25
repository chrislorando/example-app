<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

        <!-- Scripts -->
        {{-- @livewireStyles --}}
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])

        <style>
            body {
                /* display: flex; */
                align-items: center;
                padding-top: 90px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }
        </style>
        
    </head>
    <body class="antialiased">
        <div id="app">
            <main class="py-4">
                {{ $slot }}
            </main>
        </div>
        {{-- @livewireScripts --}}
        {{-- @livewireScriptConfig  --}}

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

                })
            })()
        </script>
    </body>
</html>
