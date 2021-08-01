<?php

namespace App\Http\Requests;

use App\Models\Cuisine;
use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'website' => ['nullable', 'url'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string'],
            'cuisines' => ['nullable', 'array'],
            'cuisines.*' => [function ($attribute, $value, $fail) {
                if (!($value && $value['id'] && Cuisine::find($value['id']))) {
                    $fail("{$attribute} is an invalid Cuisine");
                }
            },
            ],
        ];
    }
}
