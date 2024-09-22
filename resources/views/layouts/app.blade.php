<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

        <title>
            @hasSection('title')
                @yield('title') - {{ config('app.name') }}
            @else
                {{ Route::currentRouteName() }} - {{ config('app.name') }}
            @endif
        </title>
    
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

     <!-- Modal para crear publicaciones -->
<div id="modal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-11/12 max-w-lg">
        <h2 class="text-lg font-bold mb-4">Crear Publicación</h2>
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <textarea name="text" class="form-textarea mt-1 block w-full" placeholder="Escribe algo..."></textarea>
            </div>

            <br>

            <!-- Input para imagen con vista previa -->
            <div class="mb-4">
                <button type="button" onclick="document.getElementById('image').click()" class="bg-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-image mr-2"></i> Subir Imagen
                </button>
                <input type="file" id="image" name="image" class="hidden" accept="image/*" onchange="previewImage(this)">
                <div id="image-preview" class="mt-2 border border-white rounded-lg p-2">
                    <img id="image-preview-img" class="w-full h-auto" />
                </div>
            <button type="button" id="remove-image" class="bg-red-500 text-white px-2 py-1 mt-2 rounded-lg hidden" onclick="removeImage()">
    <i class="fas fa-trash-alt mr-2"></i> Quitar Imagen
</button>  
            </div>

            <!-- Input para video con vista previa -->
            <div class="mb-4">
                <button type="button" onclick="document.getElementById('video').click()" class="bg-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-300">
                    <i class="fas fa-video mr-2"></i> Subir Video
                </button>
                <input type="file" id="video" name="video" class="hidden" accept="video/*" onchange="previewVideo(this)">
                <div id="video-preview" class="mt-2 border border-white rounded-lg p-2">
                </div>
<button type="button" id="remove-video" class="bg-red-500 text-white px-2 py-1 mt-2 rounded-lg hidden" onclick="removeVideo()">
    <i class="fas fa-trash-alt mr-2"></i> Quitar Video
</button>            
</div>

            <div class="flex justify-end">
                <button type="button" id="close-modal" class="mr-4 bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </button>
                <button type="submit" class="bg-gray-200 text-gray-600 px-4 py-2 rounded-lg hover:bg-gray-300">
                    Publicar
                </button>
            </div>
        </form>
    </div>
</div>

        <!-- Script para vista previa y quitar archivos -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const imageInput = document.getElementById('image');
                const imagePreview = document.getElementById('image-preview');
                const removeImageButton = document.getElementById('remove-image');

                const videoInput = document.getElementById('video');
                const videoPreview = document.getElementById('video-preview');
                const removeVideoButton = document.getElementById('remove-video');

                // Vista previa de imagen
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            imagePreview.innerHTML = `<img src="${event.target.result}" class="w-48 h-auto rounded-md" alt="Imagen seleccionada">`;
                            removeImageButton.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Quitar imagen seleccionada
                removeImageButton.addEventListener('click', function() {
                    imageInput.value = ''; // Limpiar el input
                    imagePreview.innerHTML = ''; // Eliminar la vista previa
                    removeImageButton.classList.add('hidden'); // Ocultar el botón
                });

                // Vista previa de video
                videoInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('video/')) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            videoPreview.innerHTML = `<video controls class="w-96 h-auto">
                                <source src="${event.target.result}" type="video/mp4">
                                Tu navegador no soporta el reproductor de video.
                            </video>`;
                            removeVideoButton.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // Quitar video seleccionado
                removeVideoButton.addEventListener('click', function() {
                    videoInput.value = ''; // Limpiar el input
                    videoPreview.innerHTML = ''; // Eliminar la vista previa
                    removeVideoButton.classList.add('hidden'); // Ocultar el botón
                });

                // Abrir y cerrar el modal
                document.getElementById('open-modal').addEventListener('click', function() {
                    document.getElementById('modal').classList.remove('hidden');
                });

                document.getElementById('close-modal').addEventListener('click', function() {
                    document.getElementById('modal').classList.add('hidden');
                });

                // Cerrar modal al hacer clic fuera del contenido
                window.addEventListener('click', function(e) {
                    if (e.target === document.getElementById('modal')) {
                        document.getElementById('modal').classList.add('hidden');
                    }
                });
            });
        </script>
    </body>
</html>
