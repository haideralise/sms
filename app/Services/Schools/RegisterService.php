<?php
/**
 * Created by PhpStorm.
 * User: adnansiddiq
 * Date: 10/03/2018
 * Time: 10:52 AM
 */

namespace App\Services\Schools;


use App\Models\School;
use App\User;
use Illuminate\Support\Facades\DB;

class RegisterService
{

    /**
     * @var User
     */
    protected $created_by;

    /**
     * @var array
     */
    protected $info;

    /**
     * RegisterService constructor.
     * @param User $created_by
     * @param array $info
     */
    public function __construct(User $created_by, array $info)
    {
        $this->created_by = $created_by;
        $this->info = $info;
    }

    /**
     * @return School
     */
    public function call()
    {
        $school = DB::transaction(function () {

            $school = new School($this->info);
            $school->created_by = $this->created_by->id;
            $school->save();

            $this->info['name'] = 'Main';

            $campus = (new CreateCampusService($school, $this->created_by, $this->info))->call();

            $school->main_campus_id = $campus->id;
            $school->save();

            return $school;
        });

        $school->refresh();

        return $school;
    }

}