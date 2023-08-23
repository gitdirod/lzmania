<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'name' => [
                'required',
                'unique:products',
                'string',
                'max:255'
            ],
            'code' => [
                'required',
                'unique:products',
                'string',
                'max:255'
            ],
            'category' => [
                'required',
                'numeric'
            ],
            'type' => [
                'required',
                'numeric'
            ],
            'available' => [
                'required',
                'boolean'
            ],
            'description' => [
                'required',
                'max:2024'
            ],

            'images' => [
                'required',
                'array',
                'max:8'
            ],
            'images.*' => [
                'required',
                'image',
                'distinct'
            ],
            'weight' => [
                'sometimes',
                'string',
                'max:255'
            ],
            'size' => [
                'sometimes',
                'string',
                'max:255'
            ],
            'number_color' => [
                'sometimes',
                'string',
                'max:255'
            ],
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Nombre es obligatorio.',
            'name.unique' => 'Nombre ya existe, usa otro.',
            'code.required' => 'Código es obligatorio.',
            'code.unique' => 'Código existente, usa otro.',
            'category.required' => 'Categoría es obligatoria.',
            'category.numeric' => 'Categoría invalida.',
            'type.required' => 'Tipo de producto es obligatorio',
            'type.numeric' => 'Tipo de producto invalido',
            'description.required' => 'Descripción es obligatoria.',
            'images.required' => 'Carga al menos una imagen.',
            'images.*.distinct' => 'Imagenes repetidas.',
        ];
    }
}
