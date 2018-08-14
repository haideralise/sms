<?php

namespace App\Http\Requests\Students;


use App\Http\Requests\Request;
use App\Models\Campus;
use App\User;

class GetRequest extends Request
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
            'query' => 'max:100',
            'section_id' => 'exists:sections,id',
            'guardian_id' => 'exists:users,id,type,' . User::TYPE_GUARDIAN,
        ];
    }
}
