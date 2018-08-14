<?php

namespace App\Http\Requests\Students;

use App\Http\Requests\Request;

class ShowRequest extends Request
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
            //
        ];
    }
}
