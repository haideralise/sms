<?php

namespace App\Http\Requests\Students;

use App\Http\Requests\Request;
use App\User;

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
            'first_name' => 'required|max:100',
            'middle_name' => 'max:100',
            'last_name' => 'required|max:100',
            'dob' => 'required|date_format:Y-m-d',
            'gender' => 'required|in:0,1',
            'email' => 'email',
            'address' => 'max:255',
            'city' => 'max:100',
            'country' => 'max:100',
            'agree_amount' => 'required|numeric|min:0|max:99999.99',
            'guardian' => 'required|array',
            'guardian.id' => 'exists:users,id,type,' . User::TYPE_GUARDIAN,
            'guardian.first_name' => 'max:100',
            'guardian.last_name' => 'max:100',
            'guardian.email' => 'email',
            'section' => 'required|array',
            'section.id' => 'required|exists:sections,id',
        ];
    }

    //TODO: need to validate section belong to given campus

    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->after(function($validator) {

            if ($validator->errors()->count() != 0) {
                return $validator;
            }

            $guardian = $this->get('guardian');

            if (isset($guardian['id'])) {
                return $validator;
            }

            if (isset($guardian['first_name']) && isset($guardian['last_name'])) {
                return $validator;
            } else {
                $validator->errors()->add('first_name', 'guardian information is required.');
            }

            return $validator;
        });

        return $validator;
    }

    /**
     * @param null $keys
     * @return array
     */
    public function all($keys = null)
    {
        $input = parent::all($keys);

        if (isset($input['guardian']) && is_array($input['guardian'])) {
            $guardian = $input['guardian'];
            if(isset($guardian['id'])) {
                if ($guardian['id'] == 0) {
                    unset($guardian['id']);
                    $input['guardian'] = $guardian;
                }
            }
        }

        return $input;
    }
}
