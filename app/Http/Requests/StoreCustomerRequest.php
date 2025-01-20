<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
        return [
            'first_name' => 'bail|required|regex:/^[\pL\s\.\-]+$/u|max:30',
            'last_name' => 'bail|required|regex:/^[\pL\s\.\-]+$/u|max:30',
            'email' => 'bail|required|email|unique:customers',
            'birthdate' => 'required|date|before_or_equal:' . now()->subYear()->format('Y-m-d')
        ];
    }
}
