<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TextRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'subject' => 'required|string|max:255',
            'short_description' => 'required|string|max:5000',
            'receiver_id' => 'required|exists:users,id',
        ];
    }

    public function messages()
    {
        return [
            'subject.required' => 'El asunto es obligatorio.',
            'subject.string' => 'El asunto debe ser una cadena de texto.',
            'subject.max' => 'El asunto no puede tener más de 255 caracteres.',
            'short_description.required' => 'La descripción breve es obligatoria.',
            'short_description.string' => 'La descripción breve debe ser una cadena de texto.',
            'short_description.max' => 'La descripción breve no puede tener más de 5000 caracteres.',
            'receiver_id.required' => 'El receptor es obligatorio.',
            'receiver_id.exists' => 'El receptor seleccionado no es válido.',
        ];
    }
}
