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
            'price' => [
                'required',
                'numeric'
            ],
            'units' => [
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
                'max:1'
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
            'name.required' => 'El nombre es obligatorio',
            'name.unique' => 'El nombre ya existe, usa otro',
            'category.required' => 'La categoría es obligatoria',
            'category.numeric' => 'La categoría debe ser valida',
            'type.required' => 'El tipo es obligatorio',
            'type.numeric' => 'El tipo debe ser valido',
            'price.required' => 'El precio es obligatorio',
            'price.numeric' => 'El precio debe ser numérico',
            'units.required' => 'Las unidades son obligatorias',
            'units.numeric' => 'Las unidades deben ser numéricas',
            'description.required' => 'La descripción es obligatoria',
            'images.required' => 'La imagen es obligatoria',
            'images.*.distinct' => 'Imagenes repetidas',
        ];
    }
}
