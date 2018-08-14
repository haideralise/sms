<?php

namespace App\Http\Requests;


/**
 * Class LoginRequest
 * @package App\Http\Requests
 *
 * @property string login
 * @property string password
 */
class LoginRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required|string',
            'password' => 'required|string'
        ];
    }
}
