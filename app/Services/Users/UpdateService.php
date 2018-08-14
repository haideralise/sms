<?php
/**
 * Created by PhpStorm.
 * User: adnansiddiq
 * Date: 10/03/2018
 * Time: 10:07 PM
 */

namespace App\Services\Users;


use App\Models\Campus;
use App\Models\Guardian;
use App\Models\Teacher;
use App\User;
use function foo\func;
use Illuminate\Support\Facades\DB;

class UpdateService
{
    /**
     * @var Campus
     */
    protected $campus;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var User
     */
    protected $updatedBy;

    /**
     * @var array
     */
    protected $info;

    /**
     * UpdateService constructor.
     * @param Campus $campus
     * @param User $user
     * @param User $updatedBy
     * @param array $info
     */
    public function __construct(Campus $campus, User $user, User $updatedBy, array $info)
    {
        $this->campus = $campus;
        $this->user = $user;
        $this->updatedBy = $updatedBy;
        $this->info = $info;
    }

    public function updateStudent()
    {
        $student = DB::transaction(function () {

            $this->user->update($this->info);

            if(isset($this->info['guardian'])) {

                $guardian_info = $this->info['guardian'];

                if (isset($guardian_info['id'])) {
                    $guardian = Guardian::find($guardian_info['id']);
                    $guardian->update($guardian_info);

                } else {
                    $service = new RegisterService($this->info['guardian']);
                    $guardian = $service->setCreatedBy($this->updatedBy)->createGuardian();
                }
                $this->user->guardian_id = $guardian->id;
            }

            $this->user->save();

            return $this->user;
        });

        $student->refresh();

        return $student;
    }


    /**
     * @return Teacher
     */
    public function updateTeacher()
    {
        $teacher = DB::transaction(function () {

            $this->user->update($this->info);

            return $this->user;
        });

        $teacher->refresh();

        return $teacher;
    }

}