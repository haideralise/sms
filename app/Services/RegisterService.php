<?php
/**
 * Created by PhpStorm.
 * User: adnansiddiq
 * Date: 10/03/2018
 * Time: 11:21 AM
 */

namespace App\Services;


use App\Models\Staff;
use App\Services\Schools\RegisterService as SchoolRegisterService;
use App\Services\Users\RegisterService as UserRegisterService;
use Illuminate\Support\Facades\DB;

class RegisterService
{
    /**
     * @var array
     */
    protected $info;

    /**
     * RegisterService constructor.
     * @param array $info
     */
    public function __construct(array $info)
    {
        $this->info = $info;
    }


    /**
     * @return Staff
     * @throws \Exception
     */
    public function call()
    {
        if (!isset($this->info['user'])) {
            throw new \Exception('user information is missing', 400);
        }

        if (!isset($this->info['school'])) {
            throw new \Exception('school information is missing', 400);
        }

        $user = DB::transaction(function () {

            $user_info = $this->info['user'];

            $user = (new UserRegisterService($user_info))->createStaff();

            $school_info = $this->info['school'];

            (new SchoolRegisterService($user, $school_info))->call();

            return $user;
        });

        return $user;
    }
}