<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierStoreRequest extends FormRequest
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
            'supplier_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'opening_balance' => 'nullable|numeric',
            'balance_type' => 'required',
            'is_active' => 'required|boolean',
        ];
    }


    public function messages()
    {
        return [
            'supplier_name.required' => 'The company name is required.',
            'supplier_name.string' => 'The company name must be a valid string.',
            'supplier_name.max' => 'The company name must not exceed 255 characters.',

            'contact_person.string' => 'The contact person name must be a valid string.',
            'contact_person.max' => 'The contact person name must not exceed 255 characters.',

            'phone.string' => 'The phone number must be a valid string.',
            'phone.max' => 'The phone number must not exceed 20 characters.',

            'email.email' => 'The email address must be a valid email.',
            'email.max' => 'The email address must not exceed 255 characters.',

            'address.string' => 'The address must be a valid string.',

            'opening_balance.numeric' => 'The opening balance must be a valid number.',

            'is_active.required' => 'The status field is required.',
            'is_active.boolean' => 'The status must be either active or inactive.',
        ];
    }


}
