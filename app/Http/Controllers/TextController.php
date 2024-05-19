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
    public function index(Request $request)
    {
        $sort = $request->input('sort', 'desc');
        $messages = Text::where('receiver_id', Auth::id())
            ->with('sender')
            ->orderBy('created_at', $sort)
            ->simplePaginate(4);
        return view('texts.index', compact('messages', 'sort'));
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

        return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
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

    public function unreadCount()
    {
        $unreadCount = Text::where('receiver_id', Auth::id())
            ->where('is_read', false) // Asegúrate de tener una columna 'is_read' en tu tabla 'texts'
            ->count();
        return response()->json(['unread_count' => $unreadCount]);
    }

    public function toggleRead(Request $request, $id)
    {
        $message = Text::findOrFail($id);
        $message->is_read = !$message->is_read;
        $message->save();

        return response()->json(['success' => true]);
    }
}
