<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
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
            'team_id' => ['required', 'integer', 'exists:teams,id'],
            'display_until' => ['nullable', 'date'],
            'status' => ['required', 'in:Published,Draft'],
            'title' => ['required', 'string', 'max:40'],
            'slug' => ['required', 'string', 'max:40'],
            'content' => ['required', 'string'],
            'phone' => ['string', 'max:20'],
            'email' => ['email', 'max:60'],
            'from_home' => ['nullable', 'boolean','default:false'],
            'address' => ['nullable', 'string'],
            'address_ward' => ['nullable', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'directions' => ['nullable', 'string', 'max:400'],
            'times' => ['nullable', 'string', 'max:400'],
            'minimum_age' => ['nullable', 'integer'],
            'maximum_age' => ['nullable', 'integer'],
            'cost' => ['nullable', 'string', 'max:400'],
            'what_to_bring' => ['nullable', 'string', 'max:400'],
            'qualification' => ['nullable', 'string', 'max:400'],
            'requirements' => ['nullable', 'string', 'max:400'],
            'booking_link' => ['nullable', 'url', 'max:200'],
            'booking_instructions' => ['nullable', 'string', 'max:400'],
        ];
    }
}
