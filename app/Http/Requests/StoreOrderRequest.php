<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'total' => [
                'required',
                'numeric'
            ],
            'subtotal' => [
                'required',
                'numeric'
            ],
            'address_envoice_id' => [
                'required',
                'numeric'
            ],
            'address_send_id' => [
                'required',
                'numeric'
            ],

            'products' => [
                'required',
                'array',
                'min:1'
            ],
            'products.*.id' => [
                'required',
                'numeric',
            ],
            'products.*.quantity' => [
                'required',
                'numeric',
            ],

            'images' => [
                'array',
                'max:1'
            ],
            'images.*' => [
                'required',
                'image',
                'distinct'
            ]
        ];
    }
}
