<?php
/**
 * Created by PhpStorm.
 * User: adnansiddiq
 * Date: 10/03/2018
 * Time: 10:34 AM
 */

namespace App\Services\Users;


use App\Models\Campus;
use App\Models\Section;
use App\Models\Staff;
use App\Models\Student;
use App\Models\Guardian;
use App\Models\Subject;
use App\Models\Teacher;
use App\User;
use function foo\func;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterService
{
    /**
     * @var array
     */
    protected $info;

    /**
     * @var User
     */
    protected $created_by;

    /**
     * @var Campus
     */
    protected $campus;

    /**
     * RegisterUserService constructor.
     * @param array $info
     */
    public function __construct(array $info)
    {
        $this->info = $info;

        if (isset($this->info['password'])) {
            $this->info['password'] = Hash::make($this->info['password']);
        }
    }

    /**
     * @param User $created_by
     * @return RegisterService
     */
    public function setCreatedBy($created_by)
    {
        $this->created_by = $created_by;
        return $this;
    }

    /**
     * @param Campus $campus
     * @return RegisterService
     */
    public function setCampus($campus)
    {
        $this->campus = $campus;
        return $this;
    }

    /**
     * @return Student
     * @throws \Exception
     */
    public function createStudent()
    {
        if (empty($this->created_by)) {
            throw new \Exception('created by is not found', 400);
        }

        if (!isset($this->info['guardian'])) {
            throw new \Exception('Guardian is not found', 400);
        }

        if (empty($this->campus)) {
            throw new \Exception('Campus is not found', 400);
        }

        $section = Section::find($this->info['section']['id']);

        if($section->grade->campus_id != $this->campus->id) {
            throw new \Exception('Section is not valid', 400);
        }

        $campus = $this->campus;

        $student = DB::transaction(function () use ($campus, $section) {

            $guardian_info = $this->info['guardian'];

            if (isset($guardian_info['id'])) {
                $guardian = Guardian::find($guardian_info['id']);
            } else {
                $service = new RegisterService($this->info['guardian']);
                $guardian = $service->setCreatedBy($this->created_by)->createGuardian();
            }

            $student = new Student($this->info);

            $student->created_by = $this->created_by->id;

            $student->guardian_id = $guardian->id;

            $student->setCampus($campus)
                ->setSection($section)
                ->save();

            return $student;
        });

        $student->refresh();

        return $student;
    }

    /**
     * @return Guardian
     * @throws \Exception
     */
    public function createGuardian()
    {
        if (empty($this->created_by)) {
            throw new \Exception('created by is not found', 400);
        }

        $supervisor = new Guardian($this->info);
        $supervisor->created_by = $this->created_by->id;

        $supervisor->save();
        $supervisor->refresh();

        return $supervisor;
    }

    /**
     * @return Staff
     */
    public function createStaff()
    {
        $staff = DB::transaction(function () {

            $staff = new Staff($this->info);

            if (!empty($this->created_by)) {
                $staff->created_by = $this->created_by->id;
            }

            if (!empty($this->campus)) {
                $staff->setCampus($this->campus);
            }

            $staff->save();

            return $staff;
        });

        $staff->refresh();

        return $staff;
    }

    /**
     * @return Teacher
     * @throws \Exception
     */
    public function createTeacher()
    {
        if (empty($this->created_by)) {
            throw new \Exception('created by is not found', 400);
        }

        if (empty($this->campus)) {
            throw new \Exception('campus is not found', 400);
        }

        $section_assignments = $this->getSectionsIds();

        $teacher = DB::transaction(function () use ($section_assignments) {

            $teacher = new Teacher($this->info);

            $teacher->created_by = $this->created_by->id;

            if (!empty($this->campus)) {
                $teacher->setCampus($this->campus);
            }

            $teacher->save();

            if (!empty($section_assignments)) {

                foreach ($section_assignments as $section_assignment) {
                    $teacher->sectionAssignments()->create($section_assignment);
                }
            }

            return $teacher;
        });

        $teacher->refresh();

        return $teacher;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function getSectionsIds()
    {
        $section_ids = [];

        if (isset($this->info['sections']) && is_array($this->info['sections'])) {

            $sections = $this->info['sections'];

            foreach ($sections as $section) {

                $sectionObj = Section::find($section['id']);

                if ($sectionObj->grade->campus_id != $this->campus->id) {
                    throw new \Exception('Section is not belong to campus', 400);
                }

                $temp = [
                    'section_id' => $sectionObj->id,
                ];

                if (isset($section['subject']) && isset($section['subject']['id'])) {

                    $subject = Subject::find($section['subject']['id']);
                    if ($subject->campus_id != $this->campus->id) {
                        throw new \Exception('Subject is not belong to campus', 400);
                    }

                    $temp['subject_id'] = $subject->id;
                }

                $section_ids[] = $temp;
            }
        }

        return $section_ids;
    }

}