<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'recipients' => 'required|string',
            'user_id' => 'required_if:recipients,specific|nullable|exists:users,id'
        ];
    }

    /**
     * Get the custom error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'حقل العنوان مطلوب.',
            'title.string' => 'يجب أن يكون العنوان نصًا.',
            'title.max' => 'يجب ألا يتجاوز العنوان :max حرفًا.',
            'message.required' => 'حقل الرسالة مطلوب.',
            'message.string' => 'يجب أن تكون الرسالة نصًا.',
            'recipients.required' => 'يرجى تحديد المستلمين (الكل أو مستخدم محدد).',
            'user_id.required_if' => 'في حال اختيار "مستخدم محدد"، يجب اختيار المستخدم.',
            'user_id.exists' => 'المستخدم الذي تم اختياره غير صالح أو غير موجود.',
        ];
    }
}
