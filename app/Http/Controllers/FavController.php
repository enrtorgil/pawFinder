<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavController extends Controller
{
    public function favorite(Publication $publication)
    {
        $user = Auth::user();
        if (!$user->favs->contains($publication->id)) {
            $user->favs()->attach($publication->id);
        }

        return back()->with('success', 'Publicación marcada como favorita.');
    }

    public function unfavorite(Publication $publication)
    {
        $user = Auth::user();
        if ($user->favs->contains($publication->id)) {
            $user->favs()->detach($publication->id);
        }

        return back()->with('success', 'Publicación desmarcada como favorita.');
    }

    public function index()
    {
        $user = Auth::user();
        $favs = $user->favs;

        return view('favs.index', compact('favs'));
    }
}
