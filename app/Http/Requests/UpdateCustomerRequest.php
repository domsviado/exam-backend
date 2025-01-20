<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $customerId = $this->route('id');
        return [
            'first_name' => 'bail|required|regex:/^[\pL\s\.\-]+$/u|max:30',
            'last_name' => 'bail|required|regex:/^[\pL\s\.\-]+$/u|max:30',
            'email' => [
                'bail',
                'required',
                'email',
                Rule::unique('customers')->ignore($customerId),
            ],
            'birthdate' => 'required|date|before_or_equal:' . now()->subYear()->format('Y-m-d')
        ];
    }
}
