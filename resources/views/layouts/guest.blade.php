<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">


        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased overflow-hidden">

    <nav x-data="{ open: false }" class="bg-white border-b-2 border-gray-200 py-3">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl  mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex justify-between items-center w-full">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="#">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Iniciar Sesión') }}
                    </x-nav-link>
                     <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        {{ __('Registro') }}
                    </x-nav-link>
                </div>
            </div>
        </div>
    </div>
</nav>

            
<div class="relative flex flex-col items-center sm:pt-0 h-screen">

    <!-- Video de fondo -->
    <video autoplay muted loop class="absolute video-login inset-0 z-0 w-full h-full object-cover">
        <source src="{{ asset('videofondoo.mp4') }}" type="video/mp4">
        Tu navegador no soporta el video.
    </video>

    <!-- Contenido del sitio (colocado encima del video) -->
     <div class="relative z-10 mt-6">
        <h1 class="font-black text-4xl text-extrabold tracking-wide">Bienvenido a FIX</h1>
    </div> 

    <!-- Contenido adicional -->
    <div class="relative z-10 w-full sm:max-w-md mt-4 px-6 py-4 bg-white bg-opacity-5 backdrop-blur-md shadow-md overflow-hidden sm:rounded-lg">
    {{ $slot }}
    </div>

</div>




    </body>
</html>
