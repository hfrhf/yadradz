<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlacklistRequest extends FormRequest
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
            // نفس القواعد المحسّنة لعملية التحديث
            'phone' => 'required_without:ip_address|nullable|string|max:20',
            'ip_address' => 'required_without:phone|nullable|ip',
            'reason' => 'nullable|string|max:500',
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
            'required_without' => 'يجب توفير :attribute أو :values على الأقل.',
            'string'   => 'حقل :attribute يجب أن يكون نصًا.',
            'ip'       => 'حقل :attribute يجب أن يكون عنوان IP صالحًا.',
            'max'      => 'حقل :attribute لا يجب أن يتجاوز :max حرفًا.',
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
            'phone'      => 'رقم الهاتف',
            'ip_address' => 'عنوان IP',
            'reason'     => 'السبب',
        ];
    }
}
