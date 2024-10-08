<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Post;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Validar datos
    $validatedData = $request->validated();

    // Si se subió una nueva imagen de perfil
    if ($request->hasFile('profile_image')) {
        // Obtener el archivo
        $file = $request->file('profile_image');

        // Generar un nombre único para la imagen
        $fileName = $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();

        // Guardar la imagen en la carpeta storage/app/public/profile_images
        $filePath = $file->storeAs('profile_images', $fileName, 'public');

        // Guardar la ruta de la imagen en el campo profile_image del usuario
        $validatedData['profile_image'] = $filePath;
    }

    // Actualizar la biografía y otros datos
    $user->fill($validatedData);

    // Si el email cambió, reiniciar la verificación
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function show(): View
{
    $user = Auth::user(); // Obtén el usuario autenticado

    // Obtén los posts del usuario, ordenados del más reciente al más antiguo
    $posts = Post::where('user_id', $user->id)
        ->orderBy('created_at', 'desc') // Ordenar por fecha de creación en orden descendente
        ->get();

    // Redirige a la vista personalProfile con el usuario y sus posts
    return view('personalProfile', compact('user', 'posts'));
}



public function showUserProfile(User $user)
{
    // Obtener los posts del usuario, ordenados del más reciente al más antiguo
    $posts = Post::where('user_id', $user->id)
        ->orderBy('created_at', 'desc') // Ordenar por fecha de creación en orden descendente
        ->get();

    // Retornar la vista del perfil del usuario con sus posts
    return view('userProfile', [
        'user' => $user,
        'posts' => $posts,
    ]);
}


}
