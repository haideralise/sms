<?php

namespace App\Http\Requests\Subjects;

use App\Http\Requests\Request;

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

        $subject = $this->subject();

        return $campus->subjects()->where('subjects.id', $subject->id)->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => 'max:100',
            "code" => 'max:10',
            'description' => 'max:255',
        ];
    }
}
