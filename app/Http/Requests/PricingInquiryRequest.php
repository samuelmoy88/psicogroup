<?php

namespace App\Http\Requests;

use App\Rules\HasUserAcceptedConditions;
use Illuminate\Foundation\Http\FormRequest;

class PricingInquiryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'max:100'],
            'last_name' => ['required', 'max:100'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'numeric', 'min:9'],
            'premium_plan' => ['required'],
            'user_accepts' => [new HasUserAcceptedConditions()]
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('common.premium_inquiry_first_name_required'),
            'first_name.max' => __('common.premium_inquiry_first_name_max'),
            'last_name.required' => __('common.premium_inquiry_last_name_required'),
            'last_name.max' => __('common.premium_inquiry_last_name_max'),
            'email.required' => __('common.premium_inquiry_email_required'),
            'email.email' => __('common.premium_inquiry_email_email'),
            'phone.required' => __('common.premium_inquiry_phone_required'),
            'phone.numeric' => __('common.premium_inquiry_phone_numeric'),
            'phone.min' => __('common.premium_inquiry_phone_min'),
            'premium_plan.required' => __('common.premium_inquiry_premium_plan_required'),
        ];
    }
}
