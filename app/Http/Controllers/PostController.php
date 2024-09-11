<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->get();
        return view('dashboard', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video' => 'nullable|mimes:mp4,avi,mov|max:40000',
        ]);

        if (!$request->filled('text') && !$request->hasFile('image') && !$request->hasFile('video')) {
            return redirect()->back()->withErrors(['error' => 'El post debe contener al menos un texto, una imagen o un video.']);
        }

        $post = new Post();
        $post->text = $request->input('text');
        $post->user_id = Auth::id();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = Auth::user()->name . '_' . time() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/images', $imageName);
            $post->image = 'images/' . $imageName;
        }

        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = Auth::user()->name . '_' . time() . '.' . $video->getClientOriginalExtension();
            $videoPath = $video->storeAs('public/videos', $videoName);
            $post->video = 'videos/' . $videoName;
        }

        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post creado exitosamente.');
    }
}
