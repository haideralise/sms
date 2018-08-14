<?php

namespace App\Http\Requests\Attendances;

use App\Http\Requests\Request;
use App\User;

class SaveStudentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->campus = $this->section()->grade->campus;

        return $this->validateStaff();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->campus = $this->section()->grade->campus;

        return [
            'date' => 'required|date_format:Y-m-d',
            'students' => 'required|array',
            'students.*.id' => 'required|exists:users,id,type,' . User::TYPE_STUDENT . ',campus_id,' . $this->campus->id,
            'students.*.status_id' => 'required|exists:attendance_statuses,id'
        ];
    }
}
