<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Unicon S.A.</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}} ">
    <!-- Scripts -->

    {{--  @vite(['resources/sass/app.scss'])  --}}
    <link rel="stylesheet" href="{{asset('css/style.css')}} ">
    @livewireStyles()
</head>
<body>

        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" role="status"></div>
        </div>
    <div id="app">
        @include('layouts.theme.sidebar')
        @include('layouts.theme.header')
        <main class="py-4">
            {{ $slot }}
        </main>
    </div>
    

    
    @livewireScripts()
    {{-- @vite(['resources/js/app.js']) --}}
    <script src="{{asset('build/assets/app-XM1nyk2I.js')}}"></script>
    <script src="{{asset('js/action.js')}}"></script>
    @yield('scripts')
</body>
</html>
