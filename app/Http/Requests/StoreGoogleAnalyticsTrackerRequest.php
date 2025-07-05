<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGoogleAnalyticsTrackerRequest extends FormRequest
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
            'identifier' => 'required|string|max:255|unique:marketing_trackers,identifier,NULL,id,type,ga',
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
            'unique'   => 'قيمة :attribute مستخدمة بالفعل.',
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
            'identifier' => 'المعرّف (Tracking ID)',
        ];
    }
}
