<?php

namespace App\Http\Requests\Sections;

use App\Http\Requests\Request;

class SyncSubjectRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->getCampus();

        if (!$this->validateStaff()) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $campus = $this->getCampus();

        return [
            'subjects' => 'required|array|min:1',
            'subjects.*.id' => 'required|exists:subjects,id,campus_id,' . $campus->id,
        ];
    }

    /**
     * @return \App\Models\Campus
     */
    public function getCampus()
    {
        if (empty($this->campus)) {

            $section = $this->section();
            $grade = $section->grade()->first();
            $this->campus = $grade->campus;
        }

        return $this->campus;
    }
}
