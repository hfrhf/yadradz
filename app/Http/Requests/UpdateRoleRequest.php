<?php

namespace App\Http\Requests;

use App\Http\Requests\StoreRoleRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateRoleRequest extends FormRequest
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
        $roleId = $this->route('role')->id;

        return [
            // إضافة التحقق من الاسم عند التحديث لضمان الاتساق
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles')->ignore($roleId),
            ],
            'permissions'   => 'required|array|min:1',
            'permissions.*' => 'required|exists:permissions,id',
        ];
    }

    /**
     * Get the custom error messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        // إعادة استخدام نفس الرسائل من كلاس الإنشاء
        return (new StoreRoleRequest())->messages();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        // إعادة استخدام نفس الأسماء من كلاس الإنشاء
        return (new StoreRoleRequest())->attributes();
    }
}
