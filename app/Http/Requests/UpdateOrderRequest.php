<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
            // 'envoice' => [
            //     'required',
            //     'unique:orders,envoice,' . $this->id,
            //     'string',
            //     'max:255'
            // ],
            'envoice' => [
                'string',
                'max:255'
            ],
            'state' => [
                'required',
                'numeric'
            ],
            'payment' => [
                'required',
                'numeric'
            ],
        ];
    }
}
