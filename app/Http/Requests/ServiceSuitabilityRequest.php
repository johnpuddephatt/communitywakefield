<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceSuitabilityRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:40'],
            'slug' => ['required', 'string', 'max:40'],
            'icon' => ['nullable', 'string'],
            'image' => ['nullable', 'string', 'max:200'],
            'colour' => ['nullable', 'string', 'max:7']
        ];
    }
}
