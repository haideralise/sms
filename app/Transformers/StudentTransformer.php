<?php
/**
 * Created by PhpStorm.
 * User: adnansiddiq
 * Date: 15/03/2018
 * Time: 6:45 PM
 */

namespace App\Transformers;


use App\Models\Student;

class StudentTransformer
{
    /**
     * @var Student
     */
    protected $student;

    /**
     * StudentTransformer constructor.
     * @param Student $student
     */
    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    /**
     * @return array
     */
    public function transform()
    {
        $this->student->load([
            'guardian',
            'section'
        ]);

        return $this->student->toArray();
    }
}