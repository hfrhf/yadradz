<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            'name'                               => 'required|string|max:255',
            'email'                              => 'required|email|unique:users,email',
            'password'                           => 'required|min:7',
            'role'                               => 'required|exists:roles,name',
            'confirmer_payment_type'             => 'nullable|in:per_order,monthly_salary',
            'confirmer_payment_rate_monthly'     => 'nullable|numeric|min:0|required_if:confirmer_payment_type,monthly_salary',
            'confirmer_payment_rate_per_order'   => 'nullable|numeric|min:0|required_if:confirmer_payment_type,per_order',
            'confirmer_cancellation_rate'        => 'nullable|numeric|min:0|required_if:confirmer_payment_type,per_order',
            'salary_payout_day'                  => 'nullable|integer|min:1|max:28|required_if:confirmer_payment_type,monthly_salary',
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
            'required'      => 'حقل :attribute مطلوب.',
            'required_if'   => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
            'unique'        => 'هذا :attribute مستخدم بالفعل.',
            'email'         => 'يجب أن يكون :attribute عنوان بريد إلكتروني صالح.',
            'min'           => 'حقل :attribute يجب أن يكون على الأقل :min.',
            'numeric'       => 'حقل :attribute يجب أن يكون رقمًا.',
            'integer'       => 'حقل :attribute يجب أن يكون عددًا صحيحًا.',
            'in'            => 'قيمة :attribute المحددة غير صالحة.',
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
            'name'                               => 'الاسم',
            'email'                              => 'البريد الإلكتروني',
            'password'                           => 'كلمة المرور',
            'role'                               => 'الدور',
            'confirmer_payment_type'             => 'نوع الدفع للمؤكد',
            'confirmer_payment_rate_monthly'     => 'معدل الدفع الشهري',
            'confirmer_payment_rate_per_order'   => 'معدل الدفع لكل طلب',
            'confirmer_cancellation_rate'        => 'معدل الإلغاء',
            'salary_payout_day'                  => 'يوم دفع الراتب',
        ];
    }
}
