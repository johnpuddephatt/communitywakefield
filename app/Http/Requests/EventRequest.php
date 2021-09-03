<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            "team_id" => ["required", "integer", "exists:teams,id"],
            "subteam_id" => ["nullable", "integer", "exists:subteams,id"],
            "start_date" => ["required", "date"],
            "end_date" => ["nullable", "date"],
            "status" => ["required", "in:Published,Draft"],
            "title" => ["required", "string", "max:400"],
            "slug" => ["nullable", "string", "max:400"],
            "content" => ["required", "string"],
            "phone" => ["nullable", "string", "max:20"],
            "email" => ["nullable", "email", "max:60"],
            "from_home" => ["nullable", "boolean"],
            "address" => ["nullable"],
            "address_ward" => ["nullable", "string", "max:100"],
            "postcode" => ["nullable", "string"],
            "latitude" => ["nullable", "numeric"],
            "longitude" => ["nullable", "numeric"],
            "directions" => ["nullable", "string", "max:400"],
            "times" => ["nullable", "string", "max:400"],
            "minimum_age" => ["nullable", "integer"],
            "maximum_age" => ["nullable", "integer"],
            "cost" => ["nullable", "string", "max:400"],
            "what_to_bring" => ["nullable", "string", "max:400"],
            "booking_link" => ["nullable", "url", "max:200"],
            "booking_instructions" => ["nullable", "string", "max:400"],
        ];
    }
}
