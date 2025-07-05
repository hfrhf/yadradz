<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminInfoRequest extends FormRequest
{
    /**
     * تحديد ما إذا كان المستخدم مخولًا بإجراء هذا الطلب.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // تأكد من أن هذا مضبوطة على true للسماح بالوصول
    }

    /**
     * احصل على قواعد التحقق التي تنطبق على الطلب.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'facebook' => ['nullable', 'url', 'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/[a-zA-Z0-9(\.\?)?]/'],
            'twitter' => ['nullable', 'url', 'regex:/^(https?:\/\/)?(www\.)?x\.com\/[a-zA-Z0-9_]{1,15}$/'],
            'whatsapp' => ['nullable', 'url', 'regex:/^(https?:\/\/)?(wa\.me\/\d{1,15}|api\.whatsapp\.com\/send\?phone=\d{1,15})$/'],
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:15',
        ];
    }

    /**
     * تخصيص رسائل الخطأ.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'facebook.url' => 'رابط الفيسبوك غير صالح.',
            'facebook.regex' => 'رابط الفيسبوك يجب أن يكون صحيحًا ويشير إلى صفحة فيسبوك.',
            'twitter.url' => 'رابط تويتر غير صالح.',
            'twitter.regex' => 'رابط تويتر يجب أن يكون صحيحًا ويشير إلى حساب تويتر.',
            'whatsapp.url' => 'رابط الواتساب غير صالح.',
            'whatsapp.regex' => 'رابط الواتساب يجب أن يكون صحيحًا ويشير إلى رقم واتساب.',
            'email.email' => 'البريد الإلكتروني غير صالح.',
            'phone.max' => 'رقم الهاتف يجب ألا يتجاوز 15 خانة.',
        ];
    }
}
