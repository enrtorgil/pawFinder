<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Cambia esto según tu lógica de autorización
    }

    public function rules()
    {
        return [
            'reason' => 'required|in:Contenido inapropiado,Información incorrecta,Spam,Otra razón',
            'additional_info' => 'nullable|string|max:200',
        ];
    }

    public function messages()
    {
        return [
            'reason.required' => 'La razón del reporte es obligatoria.',
            'reason.in' => 'La razón seleccionada no es válida.',
            'additional_info.max' => 'La información adicional no debe exceder los 200 caracteres.',
        ];
    }
}
