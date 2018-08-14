<?php

namespace App\Http\Requests\Attendances;

use App\Http\Requests\Request;

class GetStudentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->campus = $this->section()->grade()->first()->campus;

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
            'subject_id' => 'exists:subjects,id',
        ];
    }
}
