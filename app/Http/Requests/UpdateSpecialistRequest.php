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
            'first_name.required' => __('specialists.first_name_required'),
            'first_name.max' => __('specialists.first_name_max'),
            'last_name.required' => __('specialists.last_name_required'),
            'last_name.max' => __('specialists.last_name_max'),
            'profile.avatar' => __('specialists.avatar')
        ];
    }
}
