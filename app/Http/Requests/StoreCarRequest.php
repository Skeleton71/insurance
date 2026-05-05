<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'reg_number' => 'required|string|unique:cars,reg_number|regex:/^[A-Z0-9]{6,8}$/',
            'brand' => 'required|string|min:2|max:50',
            'model' => 'required|string|min:2|max:50',
            'owner_id' => 'required|exists:owners,id',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'reg_number.required' => __('messages.reg_number_required'),
            'reg_number.unique' => __('messages.reg_number_unique'),
            'reg_number.regex' => __('messages.reg_number_regex'),
            'reg_number.string' => __('messages.reg_number_string'),
            
            'brand.required' => __('messages.brand_required'),
            'brand.string' => __('messages.brand_string'),
            'brand.min' => __('messages.brand_min'),
            'brand.max' => __('messages.brand_max'),
            
            'model.required' => __('messages.model_required'),
            'model.string' => __('messages.model_string'),
            'model.min' => __('messages.model_min'),
            'model.max' => __('messages.model_max'),
            
            'owner_id.required' => __('messages.owner_id_required'),
            'owner_id.exists' => __('messages.owner_id_exists'),
        ];
    }
}
