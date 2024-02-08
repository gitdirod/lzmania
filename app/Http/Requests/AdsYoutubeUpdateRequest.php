<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdsYoutubeUpdateRequest extends FormRequest
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
                'unique:ads_youtubes',
                'string',
                'max:255'
            ],
            'url' => [
                'required',
                'unique:ads_youtubes',
                'url',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (!Str::startsWith($value, ['https://www.youtube.com', 'https://youtu.be'])) {
                        $fail('La URL no es una URL válida de YouTube.');
                    }
                },
            ]

        ];
    }
}
