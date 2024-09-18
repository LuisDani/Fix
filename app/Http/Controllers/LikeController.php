<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like($id)
{
    $post = Post::findOrFail($id);
    $user = auth()->user();

    // Asegúrate de que el usuario no haya dado ya like al post
    if (!$post->likes()->where('user_id', $user->id)->exists()) {
        $post->likes()->create(['user_id' => $user->id]);
    }

    return response()->json([
        'liked' => true,
        'likes_count' => $post->likes()->count()
    ]);
}

public function unlike($id)
{
    $post = Post::findOrFail($id);
    $user = auth()->user();

    // Asegúrate de que el usuario haya dado like al post
    $like = $post->likes()->where('user_id', $user->id)->first();
    if ($like) {
        $like->delete();
    }

    return response()->json([
        'liked' => false,
        'likes_count' => $post->likes()->count()
    ]);
}


}
