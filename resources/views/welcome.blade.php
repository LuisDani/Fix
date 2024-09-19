<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">


        <title>{{ config('title', 'Bienvenido') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class=" relative font-sans text-gray-900 antialiased overflow-hidden">
<nav x-data="{ open: false }" class="bg-transparent border-b-2 border-gray-200 py-3 z-10">
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

    <div class="container">
        <div class="video-container">
            <video src="{{ asset('welcomevid.mp4') }}" autoplay muted loop></video>
        </div>
        
        <div class="content-container">
            <img src="{{ asset('fix.webp') }}" alt="Imagen">
            <h1 class="typing-animation">Comparte tus ideas...</h1>
            <p class="fade-in-out mb-10">Únete hoy</p>
            <div class="login-register-btns">
 <a href="{{ route('register') }}" class=" text-gray-500 bg-gradient-to-r from-gray-300 to-gray-400 hover:bg-gradient-to-l hover:from-gray-300 hover:to-gray-400 focus:ring-4 focus:outline-none focus:ring-gray-400 dark:focus:ring-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Crear cuenta</a>           
           <br> <p>¿Ya tienes una cuenta?</p>
<a href="{{ route('login') }}" class=" text-gray-500 bg-gradient-to-r from-gray-300 to-gray-400 hover:bg-gradient-to-l hover:from-gray-300 hover:to-gray-400 focus:ring-4 focus:outline-none focus:ring-gray-400 dark:focus:ring-gray-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Iniciar Sesión</a>

            </div>
        </div>
    </div>
</body>
</html>