<?php

namespace App\Http\Requests;

use App\Http\Requests\StoreShippingRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingRequest extends FormRequest
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
            'municipalities'  => 'nullable|array', // التحقق من أن البلديات مصفوفة
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
        return (new StoreShippingRequest())->messages();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        // إعادة استخدام نفس الأسماء من كلاس الإنشاء
        return (new StoreShippingRequest())->attributes();
    }
}
