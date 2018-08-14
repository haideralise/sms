<?php

namespace App\Http\Requests\Teachers;


use App\Http\Requests\Request;

class DeleteRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $campus = $this->campus();

        $user = $this->user();

        if (!$campus->staffs()->where('users.id', $user->id)->exists()) {
            return false;
        }

        $teacher = $this->teacher();

        return $campus->teachers()->where('users.id', $teacher->id)->exists();
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
