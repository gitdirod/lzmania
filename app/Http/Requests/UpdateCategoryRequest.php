<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
                'unique_name_within_group_for_update:categories,name,' . $this->group_id . ',' . $this->category->id,
                'string',
                'max:255'
            ],
            'suggested' => [
                'required',
                'boolean'
            ],
            'images' => [
                'sometimes',
                'required',
                'array',
                'min:1',
                'max:1'
            ],
            'images.*' => [
                'required',
                'image',
                'distinct'
            ],
            'group_id' => [
                'required',
                'numeric',
            ]

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'name.unique' => 'El nombre ya existe, usa otro',
            'name.unique_within_group' => "El nombre ya existe para el grupo",
            'images.required' => 'La imagen es requerida',
            'images.max' => 'Solo puedes cargar una imagen',
            'group_id.required' => 'El grupo es obligatorio',
            'group_id.numeric' => 'El grupo debe ser valido'
        ];
    }
}
