<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;

class StoreCustomerOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // هنا يمكنك وضع منطق التحقق من صلاحيات المستخدم
        // على سبيل المثال، التحقق مما إذا كان المستخدم لديه الإذن لإنشاء طلب
        // حاليًا، سنسمح للجميع بإنشاء الطلب
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'fullname' => 'required|string',
           'phone' => ['required', 'regex:/^((05|06|07)[0-9]{8}|0[1-4][0-9]{7})$/'],
            'email' => 'nullable|email',
            'state_id' => 'required|exists:shippings,id',
            'municipality_id' => 'required|exists:municipalities,id',
            'address' => 'nullable|string',
            'delivery_type' => 'required|in:to_office,to_home',
            'delivery_price' => 'required|numeric',
            'total_price' => 'required|numeric',
            'attributes' => 'nullable|array',
            'attributes.*' => 'nullable',
            'coupon_code' => 'nullable|string',
            'discount_value' => 'nullable|numeric',
            'device_type' => 'nullable|string',
            'product_variation_id'=>'nullable|exists:product_variations,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {

        return [
            'fullname.required'      => __('messages.fullname_required'),
            'phone.required'         => __('messages.phone_required'),
            'phone.regex'             => __('messages.phone_invalid'), // ✅ أضف هذا السطر
            'state_id.required'      => __('messages.state_required'),
            'municipality_id.required' => __('messages.municipality_required'),
            'delivery_type.required' => __('messages.delivery_type_required'),
            'attributes.*.required'  => __('messages.attributes_required'),

        ];
    }
}