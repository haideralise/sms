<?php

namespace App\Http\Requests\Teachers;

use App\Http\Requests\Request;

class GetRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = $this->user();

        $campus = $this->campus();

        return $campus->staffs()->where('users.id', $user->id)->exists();
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
        ];
    }
}
