<x-app-layout>
    

    <div class="container mx-auto mt-10">
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <textarea name="text" class="form-textarea mt-1 block w-full" placeholder="Escribe algo..."></textarea>
            </div>
            <div class="mb-4">
                <input type="file" name="image" class="form-input mt-1 block w-full">
            </div>
            <div class="mb-4">
                <input type="file" name="video" class="form-input mt-1 block w-full">
            </div>
<button type="submit" class="text-white bg-gradient-to-r from-slate-400 via-slate-500 to-slate-600 hover:bg-gradient-to-br focus:ring-2 focus:outline-none focus:ring-slate-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">Publicar</button>

        <div class="mt-8 w-3/4 ">
            @foreach($posts as $post)
                <div class="border p-4 mb-4 flex-col justify-center">
                    <div class="flex gap-2 w-auto">
                        @if($post->user->profile_image)
                            <img src="{{ asset('storage/' . $post->user->profile_image) }}" alt="Profile Image" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"></path>
                                </svg>
                        @endif
                        <p class="text-sm mt-2">{{ $post->user->name }}</p>
                    </div>
                    <p>{{ $post->text }}</p>
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Imagen" class="mt-2 w-auto h-auto">
                    @endif
                    @if($post->video)
                        <video controls class="mt-2 w-96 h-auto">
                            <source src="{{ asset('storage/' . $post->video) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                    
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
