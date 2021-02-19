<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VolunteeringRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:400'],
            'slug' => ['required', 'string', 'max:400'],
            'content' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:60'],
            'from_home' => ['nullable', 'boolean','default:false'],
            'address' => ['nullable'],
            'address_ward' => ['nullable', 'required', 'string', 'max:100'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'directions' => ['nullable', 'string', 'max:400'],
            'places' => ['nullable', 'integer'],
            'start date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'frequency' => ['required', 'in:One-off,Fixed period,Ongoing'],
            'hours' => ['nullable', 'integer'],
            'deadline' => ['nullable', 'date'],
            'minimum_age' => ['nullable', 'integer'],
            'maximum_age' => ['nullable', 'integer'],
            'expenses' => ['nullable', 'string', 'max:400'],
            'what_to_bring' => ['nullable', 'string', 'max:400'],
            'requirements' => [''],
            'skills_needed' => [''],
            'skills_gained' => [''],
        ];
    }
}
