<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Relación con el modelo User: cada post pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Like: un post tiene muchos likes
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // Método para verificar si el post ha sido likeado por un usuario
    public function isLikedBy($user)
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
