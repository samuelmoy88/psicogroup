<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateConsultationRequest extends FormRequest
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
            'first_name' => ['required','max:80'],
            'last_name' => ['required','max:80'],
            'email' => ['required','email'],
            'phone' => ['required','numeric'],
            'first_visit' => ['required'],
            'accept_legal' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('front.consultation_request_first_name'),
            'last_name.required' => __('front.consultation_request_last_name'),
            'email.required' => __('front.consultation_request_email'),
            'phone.required' => __('front.consultation_request_phone'),
            'first_visit.required' => __('front.consultation_request_first_visit'),
            'accept_legal.required' => __('front.consultation_request_accept_legal'),
        ];
    }

    public function attributes()
    {
        return [
            'first_name' => __('front.consultation_first_name'),
            'last_name' => __('front.consultation_last_names'),
            'email' => __('front.consultation_email'),
            'phone' => __('front.consultation_phone'),
            'first_visit' => __('front.consultation_first_visit'),
            'accept_legal' => __('front.consultation_accept_legal'),
        ];
    }
}
