<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductVariationRequest extends FormRequest
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
            'product_id'         => 'required|exists:products,id',
            'sku'                => 'required|string|max:255|unique:product_variations,sku',
            'price'              => 'required|numeric|min:0',
            'quantity'           => 'required|integer|min:0',
            'attribute_values'   => 'required|array|min:1',
            'attribute_values.*' => 'required|exists:attribute_values,id',
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
            'required'           => 'حقل :attribute مطلوب.',
            'exists'             => 'قيمة :attribute المحددة غير صالحة.',
            'unique'             => 'قيمة :attribute مستخدمة بالفعل.',
            'numeric'            => 'حقل :attribute يجب أن يكون رقمًا.',
            'integer'            => 'حقل :attribute يجب أن يكون عددًا صحيحًا.',
            'min'                => 'حقل :attribute يجب أن يحتوي على عنصر واحد على الأقل.',
            'attribute_values.*.exists' => 'إحدى قيم الخصائص المحددة غير صالحة.',
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
            'product_id'       => 'المنتج',
            'sku'              => 'رمز SKU',
            'price'            => 'السعر',
            'quantity'         => 'الكمية',
            'attribute_values' => 'قيم الخصائص',
        ];
    }
}
