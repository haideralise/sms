<?php
/**
 * Created by PhpStorm.
 * User: adnansiddiq
 * Date: 10/03/2018
 * Time: 10:52 AM
 */

namespace App\Services\Schools;


use App\Models\Campus;
use App\Models\School;
use App\User;
use Illuminate\Support\Facades\DB;

class CreateCampusService
{
    /**
     * @var array
     */
    protected $info;

    /**
     * @var User
     */
    protected $user;

    /**
     * @var School
     */
    protected $school;

    /**
     * CreateCampusService constructor.
     * @param School $school
     * @param User $user
     * @param array $info
     */
    public function __construct(School $school, User $user, array $info)
    {
        $this->info = $info;
        $this->user = $user;
        $this->school = $school;
    }

    /**
     * @return Campus
     */
    public function call()
    {
        $campus = DB::transaction(function () {

            $campus = new Campus($this->info);
            $campus->created_by = $this->user->id;
            $campus->school_id = $this->school->id;
            $campus->save();

            $this->user->setCampus($campus)
                ->save();

            return $campus;
        });

        $campus->refresh();

        return $campus;
    }

}