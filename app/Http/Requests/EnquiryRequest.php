<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EnquiryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:200'],
            'phone' => ['string', 'max:20'],
            'email' => ['email', 'max:60'],
            'message' => ['required', 'string'],
            'name' => ['required', 'string', 'max:200'],
            'phone' => ['string', 'max:20'],
            'email' => ['email', 'max:60'],
            'message' => ['required', 'string'],
        ];
    }
}
