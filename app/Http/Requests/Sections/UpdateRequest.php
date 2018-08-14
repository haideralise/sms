<?php

namespace App\Http\Requests\Sections;

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
        $grade = $this->grade();

        $this->campus = $grade->campus;

        if (!$this->validateStaff()) {
            return false;
        }

        return $grade->sections()->where('sections.id', $this->section()->id)->exists();
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
                Rule::unique('sections')->ignore($this->section()->id)->where('grade_id', $this->grade()->id),
            ],
            "code" => [
                'max:10',
                Rule::unique('sections')->ignore($this->section()->id)->where('grade_id', $this->grade()->id),
            ],
        ];
    }
}
