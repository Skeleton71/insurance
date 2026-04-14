<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOwnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:50',
            'surname' => 'required|string|min:2|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('messages.name_required'),
            'name.string' => __('messages.name_string'),
            'name.min' => __('messages.name_min'),
            'name.max' => __('messages.name_max'),
            
            'surname.required' => __('messages.surname_required'),
            'surname.string' => __('messages.surname_string'),
            'surname.min' => __('messages.surname_min'),
            'surname.max' => __('messages.surname_max'),
        ];
    }
}
