<x-app-layout>
    @section('title', 'Perfil de ' . $user->name)

    <div class="container mx-auto mt-4">
        <!-- Información del perfil -->
        <div class="profile-info-container flex py-6 px-5 rounded-lg" style="background: #dfe2e9;">
            <div class="flex items-center gap-4">
                @if($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover">
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"></path>
                    </svg>
                @endif
                <div>
                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                    @if($user->biography)
                        <p class="text-gray-600 mt-2 font-normal">{{ $user->biography }}</p>
                    @else
                        <p class="text-gray-600 mt-2">Este usuario no ha agregado una biografía aún.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Publicaciones del usuario -->
        <div class="mt-8 flex flex-col items-center">
            <h3 class="text-xl font-semibold mb-4">Publicaciones de {{ $user->name }}</h3>

            @if($posts->count())
                @foreach($posts as $post)
                    <div class="border-2 border-gray-200 p-4 mb-4 post-container w-1/2 relative">
                        <!-- Mostrar la imagen de perfil del usuario y su nombre -->
                        <div class="flex items-center gap-2 mb-2">
                            @if($user->profile_image)
                                <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="w-8 h-8 rounded-full object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="currentColor" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                                </svg>
                            @endif
                            <p class="text-sm font-semibold">{{ $user->name }}</p>
                        </div>

                        <!-- Texto del post -->
                        <p>{{ $post->text }}</p>

                        <!-- Imagen del post -->
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Imagen" class="mt-2 w-auto h-auto">
                        @endif

                        <!-- Video del post -->
                        @if($post->video)
                            <video controls class="mt-2 w-96 h-auto">
                                <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif

                        <!-- Información de likes -->
                        <div class="flex items-center gap-2 mt-2">
                        <button class="like-button" data-post-id="{{ $post->id }}">
                            <i class="fa{{ $post->isLikedBy(auth()->user()) ? 's' : 'r' }} fa-heart text-gray-500" style="font-size: 1.2rem;"></i>
                        </button>
                            <span class="likes-count">{{ $post->likes_count }}</span>
                            <span class="text-gray-500 text-xs ml-4">{{ $post->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-600 mt-4">Este usuario no ha publicado nada aún.</p>
            @endif
        </div>
    </div>
</x-app-layout>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Evento para dar like
        $('.like-button').click(function (e) {
            e.preventDefault();

            var button = $(this);
            var postId = button.data('post-id');
            var icon = button.find('i');
            var url = icon.hasClass('fa-solid') ? `/posts/${postId}/unlike` : `/posts/${postId}/like`;

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.liked) {
                        // Cambiar ícono a corazón lleno
                        icon.removeClass('fa-regular fa-heart').addClass('fa-solid fa-heart text-gray-500');
                    } else {
                        // Cambiar ícono a corazón vacío
                        icon.removeClass('fa-solid fa-heart').addClass('fa-regular fa-heart');
                    }

                    // Actualizar el contador de likes
                    button.siblings('.likes-count').text(response.likes_count);
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText); // Muestra el error en la consola para depuración
                    alert('Algo salió mal. Por favor, intenta de nuevo.');
                }
            });
        });
    });
</script>

