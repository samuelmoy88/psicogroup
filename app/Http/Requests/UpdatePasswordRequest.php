<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\IsValidPassword;

class UpdatePasswordRequest extends FormRequest
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
            'currentPassword' => ['required', 'password'],
            'newPassword' => ['required','same:confirmPassword', new IsValidPassword()],
            'confirmPassword' => ['required', 'same:newPassword']
        ];
    }

    public function messages()
    {
        return [
            'currentPassword.password' => __('common.current_password_error'),
            'newPassword.same' => __("common.same_password_error"),
            'confirmPassword.same' => __("common.same_password_error"),
            'confirmPassword.required' => __("common.same_password_confirm"),
        ];
    }

    public function attributes()
    {
        return [
            'currentPassword' => __('common.current_password'),
            'newPassword' => __('common.new_password'),
            'confirmPassword' => __('common.confirm_password'),
        ];
    }
}
