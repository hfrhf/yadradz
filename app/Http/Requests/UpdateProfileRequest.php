<?php

namespace App\Http\Requests;

use App\Http\Requests\StoreProfileRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class UpdateProfileRequest extends FormRequest
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
        $userId = $this->route('profile')->id;

        return [
            'name'  => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'password'                           => 'nullable|min:7', // كلمة المرور اختيارية عند التحديث
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
        // يمكن استخدام نفس الرسائل من StoreProfileRequest
        return (new StoreProfileRequest())->messages();
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        // يمكن استخدام نفس الأسماء من StoreProfileRequest
        return (new StoreProfileRequest())->attributes();
    }
}
