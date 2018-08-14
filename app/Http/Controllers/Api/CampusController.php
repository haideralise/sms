<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Campuses;
use App\Models\Attendance\AttendanceStatus;
use App\Models\Campus;
use App\Http\Controllers\Controller;

class CampusController extends Controller
{

    /**
     * @param Campuses\LookupDataRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function lookupData(Campuses\LookupDataRequest $request, Campus $campus)
    {
        try {

            return $this->respondWithSuccess([
                'grades' => $campus->grades()->with('sections', 'sections.subjects')->get(),
                'attendance_statuses' => AttendanceStatus::all(),
            ]);
        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }
}
