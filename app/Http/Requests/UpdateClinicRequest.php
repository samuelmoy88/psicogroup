<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClinicRequest extends FormRequest
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
            'first_name' => ['required', 'max:255'],
            'profile.avatar' => ['image']
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('clinics.first_name_required'),
            'first_name.max' => __('clinics.first_name_max'),
            'profile.avatar' => __('clinics.avatar'),
        ];
    }
}
