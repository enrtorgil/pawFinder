<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PublicationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $oneYearAgo = now()->subYear()->format('Y-m-d');
        $today = now()->format('Y-m-d');

        $rules = [
            'name' => 'required|string|max:255',
            'type' => [
                'required',
                Rule::in(['se busca', 'se adopta']),
            ],
            'type_animal' => [
                'required',
                Rule::in(['perro', 'gato', 'otro']),
            ],
            'size' => [
                'required',
                Rule::in(['Grande', 'Mediano', 'Pequeño']),
            ],
            'date' => 'required|date|after_or_equal:' . $oneYearAgo . '|before_or_equal:' . $today,
            'description' => 'nullable|string|max:5000',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'zip' => 'nullable|integer|max:99999',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image';
        } elseif ($this->isMethod('put')) {
            $rules['image'] = 'nullable|image';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe superar los 255 caracteres.',
            'type.required' => 'El tipo es obligatorio.',
            'type.in' => 'El tipo seleccionado es inválido. Debe ser "se busca" o "se adopta".',
            'type_animal.required' => 'El tipo de animal es obligatorio.',
            'type_animal.in' => 'El tipo de animal seleccionado es inválido. Debe ser "perro", "gato" u "otro".',
            'size.required' => 'El tamaño es obligatorio.',
            'size.in' => 'El tamaño seleccionado es inválido. Debe ser "Grande", "Mediano" o "Pequeño".',
            'image.required' => 'La imagen es obligatoria.',
            'image.image' => 'El archivo debe ser una imagen.',
            'date.required' => 'La fecha es obligatoria.',
            'date.date' => 'La fecha debe ser una fecha válida.',
            'date.after_or_equal' => 'La fecha no puede ser anterior a un año desde hoy.',
            'date.before_or_equal' => 'La fecha no puede ser posterior a la fecha actual.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no debe superar los 5000 caracteres.',
            'street.string' => 'La calle debe ser una cadena de texto.',
            'street.max' => 'La calle no debe superar los 255 caracteres.',
            'city.string' => 'La ciudad debe ser una cadena de texto.',
            'city.max' => 'La ciudad no debe superar los 255 caracteres.',
            'country.string' => 'El país debe ser una cadena de texto.',
            'country.max' => 'El país no debe superar los 255 caracteres.',
            'zip.integer' => 'El código postal debe ser un número entero.',
            'zip.max' => 'El código postal no debe superar los 99999.',
            'latitude.required' => 'La latitud es obligatoria.',
            'latitude.numeric' => 'La latitud debe ser un número.',
            'longitude.required' => 'La longitud es obligatoria.',
            'longitude.numeric' => 'La longitud debe ser un número.',
        ];
    }
}
