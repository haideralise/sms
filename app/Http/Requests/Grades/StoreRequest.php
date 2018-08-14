<?php

namespace App\Http\Requests\Grades;

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
                Rule::unique('grades')->where('campus_id', $this->campus()->id),
            ],
            "code" => [
                'min:1',
                'max:10',
                Rule::unique('grades')->where('campus_id', $this->campus()->id),
            ],
            'fee' => 'required|numeric|min:0|max:99999.99',
            'sections' => 'array',
            'sections.*.name' => 'min:1|max:100|distinct',
            'sections.*.code' => 'min:1|max:10|distinct',
        ];
    }

}
