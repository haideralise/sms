<?php

namespace App\Http\Requests\Attendances;

use App\Http\Requests\Request;
use App\User;

class SaveTeacherRequest extends Request
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
            'date' => 'required|date_format:Y-m-d',
            'teachers' => 'required|array',
            'teachers.*.id' => 'required|exists:users,id,type,' . User::TYPE_TEACHER . ',campus_id,' . $this->campus()->id,
            'teachers.*.status_id' => 'required|exists:attendance_statuses,id'
        ];
    }
}
