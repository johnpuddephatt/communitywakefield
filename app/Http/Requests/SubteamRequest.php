<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubteamRequest extends FormRequest
{

    protected $errorBag = 'createSubteam';

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
            'name' => ['required', 'string', 'max:60'],
            'info' => ['sometimes', 'string', 'max:300'],
        ];
    }
}
