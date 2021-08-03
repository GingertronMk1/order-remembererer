<?php

namespace App\Http\Requests;

use App\Models\Vendor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PurchaseRequest extends FormRequest
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
            'vendor_id' => ['required', 'exists:'.Vendor::class.',id'],
            'expires_at' => ['required', 'after:now'],
            'user_ids' => ['required', 'array'],
            'user_ids.*' => ['required', Rule::in($this->user()->currentTeam->allUsers()->map(function($user) {
            return $user->id;
        })->toArray())],
        ];
    }

    public function messages()
    {
        $json = json_encode($this->user()->currentTeam->allUsers()->map(function($user) {
            return $user->id;
        })->toArray());

        return array_merge(parent::messages(), [
            'user_ids.*.in' => "ID not in {$json}",
        ]);
    }
}
