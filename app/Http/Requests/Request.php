<?php

namespace App\Http\Requests;

use App\Models\Campus;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Student;
use App\Models\Teacher;
use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * Class Request
 * @package App\Http\Requests
 *
 * @method User user()
 */
class Request extends FormRequest
{

    /**
     * @var Campus
     */
    protected $campus;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
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

    /**
     * Get the response for a forbidden operation.
     */
    public function failedAuthorization()
    {
        $r = response()->json([
            'error' => 'You are not authorized for this action.',
        ], 401);

        throw new HttpResponseException($r);
    }

    protected function failedValidation(Validator $validator)
    {
        $r = response()->json([
            'errors' => $validator->errors()
        ], 400);

        throw new HttpResponseException($r);
    }

    public function response(array $errors)
    {
        return response()->json([
            'errors' => $errors
        ], 400);
    }

    /**
     * @return bool
     */
    protected function validateStaff()
    {
        $user = $this->user();

        if (empty($this->campus)) {
            $this->campus = $this->campus();
        }


        return $this->campus->staffs()->where('users.id', $user->id)->exists();
    }

    /**
     * @return \Illuminate\Routing\Route|object|string | Campus
     */
    protected function campus()
    {
        return $this->route('campus');
    }

    /**
     * @return \Illuminate\Routing\Route|object|string | Student
     */
    protected function student()
    {
        return $this->route('student');
    }

    /**
     * @return \Illuminate\Routing\Route|object|string | Teacher
     */
    protected function teacher()
    {
        return $this->route('teacher');
    }

    /**
     * @return \Illuminate\Routing\Route|object|string | Grade
     */
    protected function grade()
    {
        return $this->route('grade');
    }

    /**
     * @return \Illuminate\Routing\Route|object|string | Section
     */
    protected function section()
    {
        return $this->route('section');
    }

    /**
     * @return \Illuminate\Routing\Route|object|string | Section
     */
    protected function subject()
    {
        return $this->route('subject');
    }
}
