<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSpecialistRequest extends FormRequest
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
            'last_name' => ['required', 'max:255'],
            'profile.avatar' => ['image']
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => __('Please, provide a first name'),
            'first_name.max' => __('First name must be shorter'),
            'last_name.required' => __('Please, provide a last name'),
            'last_name.max' => __('Last name must be shorter'),
            'profile.avatar' => __('Please, upload a valid image')
        ];
    }
}
