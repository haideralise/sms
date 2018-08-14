<?php

namespace App\Http\Requests\Students;

use App\Http\Requests\Request;

class UpdateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!$this->validateStaff()) {
            return false;
        }

        $campus = $this->campus();

        $student = $this->student();

        return $campus->students()->where('users.id', $student->id)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'max:100',
            'middle_name' => 'max:100',
            'last_name' => 'max:100',
            'dob' => 'date_format:Y-m-d',
            'gender' => 'in:0,1',
            'email' => 'email',
            'address' => 'max:255',
            'city' => 'max:100',
            'country' => 'max:100',
            'guardian' => 'array',
            'guardian.id' => 'exists:users,id',
            'guardian.first_name' => 'max:100',
            'guardian.last_name' => 'max:100',
            'guardian.email' => 'email',
        ];
    }
}
