<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateGoogleTagManagerRequest extends FormRequest
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
        // $this->gtm يأتي من اسم المتغير في ملف الراوت
        $trackerId = $this->route('gtm')->id;

        return [
            'identifier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('marketing_trackers', 'identifier')->ignore($trackerId),
            ],
            'is_active'  => 'required|boolean',
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
            'unique'   => 'هذا :attribute مستخدم بالفعل.',
            'boolean'  => 'حقل :attribute يجب أن يكون صحيحًا أو خاطئًا.',
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
            'identifier' => 'المعرّف (GTM ID)',
            'is_active'  => 'الحالة',
        ];
    }
}
