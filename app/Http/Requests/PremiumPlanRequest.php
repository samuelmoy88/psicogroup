<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PremiumPlanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'price' => ['required', 'numeric'],
            'discount' => ['numeric', 'max:100'],
            'status' => ['required', 'numeric', 'between:0,1']
        ];
    }

    public function messages() : array
    {
        return [
            'title.required' => __('premium-plans.title_required'),
            'title.string' => __('premium-plans.title_must_be_string'),
            'title.max' => __('premium-plans.title_max'),
            'price.required' => __('premium-plans.price_required'),
            'price.numeric' => __('premium-plans.price_must_be_numeric'),
            'discount.max' => __('premium-plans.price_max'),
            'status.required' => __('premium-plans.status_required'),
            'status.between' => __('premium-plans.status_valid_values'),
        ];
    }
}
