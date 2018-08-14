<?php

namespace App\Http\Requests\Sections;

use App\Http\Requests\Request;

class GetSubjectsRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $section = $this->section();

        $this->campus = $section->grade->campus;

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
            //
        ];
    }
}
