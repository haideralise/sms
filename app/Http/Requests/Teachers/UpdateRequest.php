<?php

namespace App\Http\Requests\Teachers;

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
        $campus = $this->campus();

        $user = $this->user();

        if (!$campus->staffs()->where('users.id', $user->id)->exists()) {
            return false;
        }

        $teacher = $this->teacher();

        return $campus->teachers()->where('users.id', $teacher->id)->exists();
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
            'phone_number' => 'max:50',
            'national_id' => 'max:50',
            'address' => 'max:255',
            'city' => 'max:100',
            'country' => 'max:100',
        ];
    }
}
