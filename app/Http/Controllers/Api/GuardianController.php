<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Students\SearchGuardianRequest;
use App\Models\Campus;
use App\Models\Guardian;

class GuardianController extends Controller
{

    public function search(SearchGuardianRequest $request, Campus $campus)
    {
        try {

            $guardians = Guardian::whereHas('students', function ($students) use ($campus) {
                return $students->where('campus_id', $campus->id);
            })->with(['students' => function ($query) use ($campus) {
                $query->where('users.campus_id', $campus->id);
                $query->select(['id', 'first_name', 'middle_name', 'last_name', 'username', 'campus_id', 'guardian_id']);
                return $query;
            }]);

            if ($request->has('query')) {
                $guardians = $guardians->searchOnFields(['first_name', 'middle_name', 'last_name', 'national_id'], $request->get('query'));
            }

            $guardians = $guardians->limit(5)->get();

            return $this->respondWithSuccess([
                'guardians' => $guardians,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }
}
