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
            <a class="text-white bg-slate-600 hover:slate-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 button-edit" href="{{route('profile.edit')}}">Editar perfil</a>
        </div>
</div>
       

<div class="container mx-auto">
    <div class="mt-8 flex flex-col items-center">
        <h3 class="text-xl font-semibold mb-4">Tus publicaciones</h3>

        @if($posts->count())
            @foreach($posts as $post)
                <div class="border-2 border-gray-200 p-4 mb-4 post-container w-1/2 shadow-md">
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
                </div>
            @endforeach
        @else
            <p class="text-gray-600 mt-4">Aún no has publicado nada.</p>
        @endif
    </div>
</div>
</x-app-layout>