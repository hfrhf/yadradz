<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'site_name'          => 'required|string|max:50',
            'header_image'       => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'logo'               => 'nullable|image|mimes:jpg,jpeg,png|max:3072',
            'sidebar_color'      => 'required|string|max:7',
            'primary_color'      => 'required|string|max:7',
            'title_color'        => 'required|string|max:7',
            'text_color'         => 'required|string|max:7',
            'button_color'       => 'required|string|max:7',
            'price_color'        => 'required|string|max:7',
            'footer_color'       => 'required|string|max:7',
            'navbar_color'       => 'required|string|max:7',
            'background_opacity' => 'required|string|max:7',
            'opacity'            => 'required|numeric|min:0|max:1',
            'content'            => 'nullable|string',
            'language'           => 'nullable|string',
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
            'max'      => 'حقل :attribute لا يجب أن يتجاوز :max حرفًا/كيلوبايت.',
            'image'    => 'الملف يجب أن يكون صورة.',
            'mimes'    => 'يجب أن تكون الصورة بصيغة: :values.',
            'numeric'  => 'حقل :attribute يجب أن يكون رقمًا.',
            'min'      => 'قيمة :attribute يجب أن تكون :min على الأقل.',
            'max'      => 'قيمة :attribute يجب أن تكون :max على الأكثر.',
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
            'site_name'          => 'اسم الموقع',
            'header_image'       => 'صورة الهيدر',
            'logo'               => 'الشعار',
            'sidebar_color'      => 'لون الشريط الجانبي',
            'primary_color'      => 'اللون الأساسي',
            'title_color'        => 'لون العنوان',
            'text_color'         => 'لون النص',
            'button_color'       => 'لون الزر',
            'price_color'        => 'لون السعر',
            'footer_color'       => 'لون التذييل',
            'navbar_color'       => 'لون شريط التنقل',
            'background_opacity' => 'لون الخلفية الشفاف',
            'opacity'            => 'الشفافية',
            'content'            => 'المحتوى',
            'language'           => 'اللغة',
        ];
    }
}
