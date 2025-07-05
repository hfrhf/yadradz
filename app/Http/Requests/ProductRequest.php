<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
        $rules = [
            'name' => 'required|min:3|max:30',
            'description' => 'required|min:15',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'file_path' => 'nullable|string',
            'quantity'=>'required|min:1|integer',
            'image' => 'nullable|image',
            'images' => 'nullable|array|max:8', // تحديد الحد الأقصى لعدد الصور بـ 8
            'images.*' => 'image', // التأكد من أن كل ملف هو صورة
            'compare_price'=>'nullable|numeric',
            'free_shipping_office'=>'nullable|boolean',
            'free_shipping_home'=>'nullable|boolean',
            'is_active'=>'nullable|boolean',
        ];

        if ($this->isMethod("POST")) {
            $rules['image'] = "required|image";
            $rules['images'] = "required|array|max:8"; // مطلوب وتحديد الحد الأقصى لعدد الصور
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'اسم المنتج مطلوب.',
            'name.min' => 'اسم المنتج يجب أن يكون على الأقل :min أحرف.',
            'name.max' => 'اسم المنتج يجب أن يكون على الاكثر :max أحرف.',
            'description.required' => 'وصف المنتج مطلوب.',
            'description.min' => 'وصف المنتج يجب أن يكون على الأقل :min أحرف.',
            'category_id.required' => 'فئة المنتج مطلوبة.',
            'price.required' => 'سعر المنتج مطلوب.',
            'price.numeric' => 'سعر المنتج يجب أن يكون رقمًا.',
            'image.required' => 'الصورة مطلوبة.',
            'image.image' => 'يجب أن تكون الصورة من نوع صورة.',
            'images.required' => 'الصور مطلوبة.',
            'images.array' => 'يجب أن يكون حقل الصور مجموعة.',
            'images.max' => 'لا يمكنك رفع أكثر من :max صور.', // رسالة عند تجاوز 8 صور
            'images.*.image' => 'يجب أن تكون كل صورة من نوع صورة.',
            'quantity.integer' => 'الكمية  غير كافية يرجى اعادة ملئ الكمية  .',

        ];
    }

}
