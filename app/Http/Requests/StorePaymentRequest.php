<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // تأكد من تعديلها إذا كنت تريد صلاحيات محددة
    }

    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:0.01|max:99999999.99',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            // رسائل amount
            'amount.required' => 'يجب إدخال المبلغ المالي',
            'amount.numeric' => 'المبلغ المالي يجب أن يكون رقماً',
            'amount.min' => 'يجب أن لا يقل المبلغ عن 0.01',
            'amount.max' => 'يجب أن لا يزيد المبلغ عن 99,999,999.99',

            // رسائل payment_date
            'payment_date.required' => 'يجب تحديد تاريخ الدفع',
            'payment_date.date' => 'تاريخ الدفع غير صالح',

            // رسائل notes
            'notes.string' => 'يجب أن تكون الملاحظات نصية',
            'notes.max' => 'يجب أن لا تتجاوز الملاحظات 1000 حرف',
        ];
    }
}