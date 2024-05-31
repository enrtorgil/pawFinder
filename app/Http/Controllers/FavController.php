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

    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $query = $user->favs()->newQuery();

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('type_animal')) {
            $query->where('type_animal', $request->input('type_animal'));
        }

        if ($request->filled('size')) {
            $query->where('size', $request->input('size'));
        }

        if ($request->filled('date')) {
            $order = $request->input('date') == 'asc' ? 'asc' : 'desc';
            $query->orderBy('date', $order);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $favs = $query->simplePaginate(3);

        return view('favs.index', compact('favs'));
    }
}
