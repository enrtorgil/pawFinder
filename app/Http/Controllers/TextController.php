<?php

namespace App\Http\Controllers;

use App\Models\Text;
use App\Models\Publication;
use App\Http\Requests\TextRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TextController extends Controller
{
    /**
     * Muestra una lista de los mensajes recibidos.
     */
    public function index()
    {
        $messages = Text::where('receiver_id', Auth::id())->with('sender')->simplePaginate(2);
        return view('texts.index', compact('messages'));
    }

    /**
     * Muestra el formulario de contacto.
     */
    public function create(Request $request)
    {
        $publication_id = $request->query('publication_id');
        $publication = Publication::findOrFail($publication_id);
        $receiver_id = $publication->user_id;
        $phone = Auth::user()->phone;

        return view('texts.create', compact('receiver_id', 'phone'));
    }

    /**
     * Almacena un nuevo mensaje en la base de datos.
     */
    public function store(TextRequest $request)
    {
        Text::create([
            'emitter_id' => Auth::id(),
            'receiver_id' => $request->input('receiver_id'),
            'subject' => $request->input('subject'),
            'short_description' => $request->input('short_description'),
        ]);

        return redirect()->route('publications.index')->with('success', 'Mensaje enviado correctamente.');
    }

    /**
     * Elimina un mensaje específico.
     */
    public function destroy($id)
    {
        $text = Text::findOrFail($id);
        $text->delete();
        return redirect()->route('texts.index')->with('success', 'Mensaje eliminado correctamente.');
    }
}
