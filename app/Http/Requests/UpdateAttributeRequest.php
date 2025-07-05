<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttributeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // اسمح للجميع بتحديث الخصائص في الوقت الحالي
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // في هذا المثال، قواعد التحديث مطابقة لقواعد الإنشاء
        // إذا كان لديك حقل فريد (unique)، ستحتاج لتعديل القاعدة هنا لتجاهل السجل الحالي
        return [
            'name'    => 'required|string|max:255',
            'name_fr' => 'required|string|max:255',
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
            'name'    => 'الاسم (بالعربية)',
            'name_fr' => 'الاسم (بالفرنسية)',
        ];
    }
}
