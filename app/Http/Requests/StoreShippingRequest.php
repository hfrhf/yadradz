<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShippingRequest extends FormRequest
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
            'state'           => 'required|string|max:255',
            'state_fr'        => 'nullable|string|max:255',
            'to_office_price' => 'required|numeric|min:0',
            'to_home_price'   => 'required|numeric|min:0',
        ];
    }

    /**
     * Get the custom error messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'حقل :attribute مطلوب.',
            'string'   => 'حقل :attribute يجب أن يكون نصًا.',
            'max'      => 'حقل :attribute لا يجب أن يتجاوز :max حرفًا.',
            'numeric'  => 'حقل :attribute يجب أن يكون رقمًا.',
            'min'      => 'قيمة :attribute يجب أن تكون :min على الأقل.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'state'           => 'الولاية (بالعربية)',
            'state_fr'        => 'الولاية (بالفرنسية)',
            'to_office_price' => 'سعر التوصيل للمكتب',
            'to_home_price'   => 'سعر التوصيل للمنزل',
        ];
    }
}

