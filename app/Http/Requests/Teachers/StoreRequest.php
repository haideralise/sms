<?php

namespace App\Http\Requests\Teachers;

use App\Http\Requests\Request;

class StoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->validateStaff();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|max:100',
            'middle_name' => 'max:100',
            'last_name' => 'required|max:100',
            'dob' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:0,1',
            'email' => 'email',
            'phone_number' => 'max:50',
            'national_id' => 'max:50',
            'address' => 'max:255',
            'city' => 'max:100',
            'country' => 'max:100',
            'sections' => 'array',
            'sections.*.id' => 'exists:sections,id',
            'sections.*.subject' => 'array',
            'sections.*.subject.id' => 'exists:subjects,id',
        ];
    }
}
