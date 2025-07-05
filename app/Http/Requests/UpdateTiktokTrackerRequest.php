<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\StoreTiktokTrackerRequest;
use Illuminate\Validation\Rule;
class UpdateTiktokTrackerRequest extends FormRequest
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
        // $this->tiktok يأتي من اسم المتغير في ملف الراوت
        $trackerId = $this->route('tiktok')->id;

        return [
            'name'       => 'required|string|max:255',
            'identifier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('marketing_trackers', 'identifier')->ignore($trackerId),
            ],
            'token'      => 'nullable|string|max:1000',
            'is_active'  => 'required|boolean',
        ];
    }

    /**
     * Get the custom error messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $messages = (new StoreTiktokTrackerRequest())->messages();
        $messages['boolean'] = 'حقل :attribute يجب أن يكون صحيحًا أو خاطئًا.';
        return $messages;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        $attributes = (new StoreTiktokTrackerRequest())->attributes();
        $attributes['is_active'] = 'الحالة';
        return $attributes;
    }
}
