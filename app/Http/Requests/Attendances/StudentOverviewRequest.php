<?php

namespace App\Http\Requests\Attendances;


use App\Http\Requests\Request;

/**
 * Class StudentOverviewRequest
 * @package App\Http\Requests\Attendances
 *
 * @property string start_date
 * @property string end_date
 */
class StudentOverviewRequest extends Request
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
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ];
    }
}
