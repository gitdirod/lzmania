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
                'unique_name_within_group_for_create:categories,name,' . $this->group_id,
                'string',
                'max:255'
            ],
            'group_id' => [
                'required',
                'numeric'
            ],
            'suggested' => [
                'required',
                'boolean'
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
