<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteColorRequest extends FormRequest
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
            'primary_color' => 'required|string|max:7',
            'title_color'   => 'required|string|max:7',
            'text_color'    => 'required|string|max:7',
            'button_color'  => 'required|string|max:7',
            'price_color'   => 'required|string|max:7',
            'footer_color'  => 'required|string|max:7',
            'navbar_color'  => 'required|string|max:7',
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
            'primary_color' => 'اللون الأساسي',
            'title_color'   => 'لون العنوان',
            'text_color'    => 'لون النص',
            'button_color'  => 'لون الزر',
            'price_color'   => 'لون السعر',
            'footer_color'  => 'لون التذييل',
            'navbar_color'  => 'لون شريط التنقل',
        ];
    }
}
