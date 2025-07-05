<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGoogleSheetRequest extends FormRequest
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
            'json'           => 'required|file|mimes:json',
            'spreadsheet_id' => 'required|string|max:255',
            'sheet_name'     => 'required|string|max:255',
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
            'file'     => 'حقل :attribute يجب أن يكون ملفًا.',
            'mimes'    => 'يجب أن يكون الملف من نوع :values.',
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
            'json'           => 'ملف Service Account JSON',
            'spreadsheet_id' => 'معرّف جدول البيانات (Spreadsheet ID)',
            'sheet_name'     => 'اسم الورقة (Sheet Name)',
        ];
    }
}
