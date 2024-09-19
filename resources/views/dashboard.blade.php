<x-app-layout>
    @section('title', 'Página de Inicio')

    <div class="container mx-auto mt-10">

        <div class="mt-8 w-full">
            @foreach($posts as $post)
                <div class="border p-4 mb-4 flex-col justify-center relative bg-white shadow-md">
                    <!-- Botón de eliminar solo para posts del usuario autenticado -->
                    @if($post->user_id === auth()->id())
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="absolute top-2 right-5">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-gray-700">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    @endif

                    <div class="flex gap-2 w-auto">
                        @if($post->user->profile_image)
                            <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="Profile Image" class="w-20 h-20 rounded-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"></path>
                            </svg>
                        @endif
                        <a href="{{ $post->user_id === auth()->id() ? route('profile.show') : route('users.profile', $post->user->id) }}" class="text-lg mt-2 text-black no-underline">{{ $post->user->name }}</a>
                    </div>

                    <!-- Fecha de creación del post -->
                    <div class="absolute right-10 top-2 text-sm text-gray-500">
                        {{ $post->created_at->diffForHumans() }}
                    </div>

                    <p>{{ $post->text }}</p>
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Imagen" class="mt-2 w-1/2 h-auto">
                    @endif
                    @if($post->video)
                        <video controls class="mt-2 w-96 h-auto">
                            <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif

                    <!-- Botón de like -->
                    <div class="flex items-center mt-4">
                        <button class="like-button" data-post-id="{{ $post->id }}">
                            @if($post->likes->where('user_id', auth()->id())->isNotEmpty())
                                <i class="fa-solid fa-heart text-gray-500" style="font-size: 1.2rem;"></i>
                            @else
                                <i class="fa-regular fa-heart text-gray-500" style="font-size: 1.2rem;"></i>
                            @endif
                        </button>
                        <span class="ml-2 likes-count">{{ $post->likes->count() }}</span>
                    </div>
                </div>
            @endforeach
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
            var url = button.find('i').hasClass('fa-solid') ? `/posts/${postId}/unlike` : `/posts/${postId}/like`;

            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.liked) {
                        // Cambiar ícono a corazón lleno
                        button.find('i').removeClass('fa-regular fa-heart text-gray-500').addClass('fa-solid fa-heart text-gray-500');
                    } else {
                        // Cambiar ícono a corazón vacío
                        button.find('i').removeClass('fa-solid fa-heart text-gray-500').addClass('fa-regular fa-heart text-gray-500');
                    }

                    // Actualizar el contador de likes
                    button.siblings('.likes-count').text(response.likes_count);
                },
                error: function () {
                    alert('Algo salió mal. Por favor, intenta de nuevo.');
                }
            });
        });
    });
</script>
