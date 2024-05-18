<?php

namespace App\Http\Controllers;

use App\Models\Fav;
use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavController extends Controller
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
    public function show(Fav $fav)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fav $fav)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fav $fav)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fav $fav)
    {
        //
    }

    public function favorite(Publication $publication)
    {
        // Aquí puedes agregar la lógica para marcar la publicación como favorita
        // Por ejemplo, puedes crear una relación de muchos a muchos entre usuarios y publicaciones favoritas

        $user = Auth::user();
        // $user->favorites()->attach($publication->id);

        return back()->with('success', 'Publicación marcada como favorita.');
    }
}
