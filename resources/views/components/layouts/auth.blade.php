<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    </body>
</html>
