<?php

namespace App\Http\Requests\Grades;

use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

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

        $grade = $this->grade();

        return $campus->grades()->where('grades.id', $grade->id)->exists();
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
                'max:100',
                Rule::unique('grades')->ignore($this->grade()->id, 'id')->where('campus_id', $this->campus()->id),
            ],
            "code" => [
                'max:100',
                Rule::unique('grades')->ignore($this->grade()->id, 'id')->where('campus_id', $this->campus()->id),
            ],
            'fee' => 'numeric|min:0|max:99999.99',
        ];
    }
}
