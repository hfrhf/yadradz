<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name'          => 'required|string|max:255|unique:roles,name',
            'permissions'   => 'required|array|min:1',
            'permissions.*' => 'required|exists:permissions,id', // التحقق من أن كل صلاحية موجودة
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
            'required'              => 'حقل :attribute مطلوب.',
            'unique'                => 'اسم :attribute مستخدم بالفعل.',
            'array'                 => 'حقل :attribute يجب أن يكون مصفوفة.',
            'min'                   => 'يجب اختيار :attribute واحدة على الأقل.',
            'permissions.*.exists'  => 'إحدى الصلاحيات المحددة غير صالحة.',
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
            'name'        => 'اسم الدور',
            'permissions' => 'الصلاحيات',
        ];
    }
}
