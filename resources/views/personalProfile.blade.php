<x-app-layout>
@section('title', 'Perfil')

<div class="flex justify-between items-center bg-gray-200 p-10 profile-container">
    <div class="flex items-center gap-x-3 left-container">
        @if($user->profile_image)
            <img src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" class="w-24 h-24 rounded-full object-cover">
        @else
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="currentColor" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
            </svg>
        @endif
        <div>
            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
            <div class="bio-container">
                @if($user->biography)
                    <p class="text-gray-600 mt-2">{{ $user->biography }}</p>
                @else
                    <p class="text-gray-600 mt-2">No has agregado una biografía aún.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="edit-button-container">
        <a class="text-white bg-slate-600 hover:bg-slate-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 button-edit" href="{{ route('profile.edit') }}">Editar perfil</a>
    </div>
</div>

<div class="container mx-auto">
    <div class="mt-8 flex flex-col items-center">
        <h3 class="text-xl font-semibold mb-4">Tus publicaciones</h3>

        @if($posts->count())
            @foreach($posts as $post)
                <div class="border-2 border-gray-200 p-4 mb-4 post-container w-1/2 shadow-md relative">
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
                        <p class="text-sm font-semibold"> {{ $user->name }}</p>
                    </div>

                    <!-- Botón de eliminar solo para posts del usuario autenticado -->
                    @if($post->user_id === auth()->id())
                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="absolute top-2 right-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-500 hover:text-gray-700">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    @endif

                    <!-- Fecha de creación del post -->
                    

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

                    <!-- Sección de likes -->
                    <div class="flex items-center mt-2">
                        <button class="like-button" data-post-id="{{ $post->id }}">
                            @if($post->isLikedBy(auth()->user()))
                                <i class="fa-solid fa-heart text-gray-500" style="font-size: 1.2rem;"></i>
                            @else
                                <i class="fa-regular fa-heart" style="font-size: 1.2rem;"></i>
                            @endif
                        </button>
                        <span class="ml-2 likes-count">{{ $post->likes->count() }}</span>
                        <span class="text-gray-500 text-xs ml-4">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-600 mt-4">Aún no has publicado nada.</p>
        @endif
    </div>
</div>
</x-app-layout>


<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<!-- Agrega los scripts para manejar los likes con AJAX -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const likeButtons = document.querySelectorAll('.like-button');

        likeButtons.forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.getAttribute('data-post-id');
                const isLiked = this.querySelector('i').classList.contains('fa-solid');

                const url = isLiked ? `/posts/${postId}/unlike` : `/posts/${postId}/like`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.liked) {
                        this.querySelector('i').classList.remove('fa-regular');
                        this.querySelector('i').classList.add('fa-solid', 'text-gray-500');
                    } else {
                        this.querySelector('i').classList.remove('fa-solid', 'text-gray-500');
                        this.querySelector('i').classList.add('fa-regular');
                    }

                    this.nextElementSibling.textContent = data.likes_count;
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>