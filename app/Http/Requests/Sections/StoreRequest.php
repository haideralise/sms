<?php

namespace App\Http\Requests\Sections;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class StoreRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $grade = $this->grade();

        $this->campus = $grade->campus;

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
            "name" => [
                'required',
                'min:1',
                'max:100',
                Rule::unique('sections')->where('grade_id', $this->grade()->id),
            ],
            "code" => [
                'min:1',
                'max:10',
                Rule::unique('sections')->where('grade_id', $this->grade()->id),
            ],
        ];
    }
}
