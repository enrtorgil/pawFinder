<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Publication;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id !== $user->id && $authUser->role !== 'administrador') {
            return redirect()->route('index')->with('error', 'No tienes permiso para editar este perfil.');
        }

        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $authUser = Auth::user();

        if ($authUser->id !== $user->id && $authUser->role !== 'administrador') {
            return redirect()->route('index')->with('error', 'No tienes permiso para actualizar este perfil.');
        }

        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.edit', $user)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $isSelfDelete = Auth::id() === $user->id;

        $user->delete();

        if ($isSelfDelete || Auth::user()->role != 'administrador') {
            Auth::logout();
            return redirect()->route('index')->with('success', 'Cuenta eliminada correctamente.');
        }

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    public function favorite(Publication $publication)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user->favs->contains($publication->id)) {
            $user->favs()->attach($publication->id);
        }

        return back()->with('success', 'Publicación marcada como favorita.');
    }

    public function unfavorite(Publication $publication)
    {
        /** @var User $user */
        $user = Auth::user();
        if ($user->favs->contains($publication->id)) {
            $user->favs()->detach($publication->id);
        }

        return back()->with('success', 'Publicación desmarcada como favorita.');
    }
}
