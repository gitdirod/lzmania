<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'group_id' => [
                'required',
                'numeric'
            ],
            'images' => [
                'required',
                'array',
                'min:1'
            ],
            'images.*' => [
                'required',
                'image',
                'distinct'
            ]
        ];
    }
}
