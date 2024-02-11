<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        // Agregar que puede editar el nomre o dejarlo como esta. aregar los array de imagen
        return [
            'name' => [
                'required',
                'unique:products,name,' . $this->product->id,
                'string',
                'max:255'
            ],
            'code' => [
                'required',
                'unique:products,code,' . $this->product->id,
                'string',
                'max:255'
            ],
            'discount' => [
                'sometimes', // Usa 'sometimes' si el campo no es obligatorio en todas las solicitudes
                'numeric', // Asegura que el campo sea numérico
                'min:0', // Establece el valor mínimo permitido a 0
                'max:100', // Establece el valor máximo permitido a 100
            ],
            'category' => [
                'required',
                'numeric'
            ],
            'type' => [
                'required',
                'numeric'
            ],
            // 'price' => [
            //     'required',
            //     'numeric'
            // ],
            // 'units' => [
            //     'required',
            //     'numeric'
            // ],
            'available' => [
                'required',
                'boolean'
            ],
            'description' => [
                'required',
                'max:2024'
            ],
            'images' => [
                'sometimes',
                'required',
                'array',
                'min:1'
            ],
            'images.*' => [
                'required',
                'image',
                'distinct'
            ],
            'deleted' => [
                'sometimes',
                'required',
                'array'
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
            'discount.numeric' => 'El descuento debe ser un número entre 0 y 100',
            'discount.min' => 'El descuento debe ser mayor a 0%',
            'discount.max' => 'El descuento debe ser menor a 100%',
        ];
    }
}
