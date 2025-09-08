<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollStoreRequest extends FormRequest
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
            'restaurant_id' => 'required|exists:restaurant_branches,id',
            'id_number' => 'required|string|unique:pay_rolls,id_number',
            'joining_date' => 'required|date',
            'employe_name' => 'required|string|max:255',
            'employe_phone' => ['nullable', 'regex:/^(?:\+8801|01)[3-9][0-9]{8}$/', 'unique:pay_rolls,employe_phone'],
            'employe_email' => 'nullable|email|max:255',
            'employe_present_address' => 'nullable|string',
            'employe_permanent_address' => 'nullable|string',
            'gender' => 'nullable|in:0,1,2',
            'employe_designation' => 'nullable|string|max:255',
            'employe_sallery' => 'nullable|numeric|min:0',
            'employe_festival_bonas' => 'nullable|numeric|min:0',
            'employe_festival_bonas_type' => 'nullable|in:cash,product,none',
            'employe_overtime_rate' => 'nullable|numeric|min:0',
            'employe_yearly_leave' => 'nullable|numeric|min:0',
            'employe_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'employe_resume' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'employe_nid_number' => 'nullable|string|max:255',
            'employe_nid_front_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'employe_nid_back_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'employe_date_of_birth' => 'nullable|date',
            'employe_edu_qualification' => 'nullable|array',
            'employe_father_name' => 'nullable|string|max:255',
            'employe_mother_name' => 'nullable|string|max:255',
        ];
    }
}
