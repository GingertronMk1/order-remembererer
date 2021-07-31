<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
        $inputs = ['food', 'drink', 'other'];
        $ret = [];
        foreach ($inputs as $current_input) {
            $other_inputs = array_filter(
                $inputs,
                function ($input) use ($current_input) {
                    return $input !== $current_input;
                }
            );

            $ret[$current_input] = [
                'required_without:'.
                implode(
                    ',',
                    $other_inputs
                ),
            ];
        }

        return $ret;
    }
}
