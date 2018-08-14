<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Attendances;
use App\Models\Attendances\TeacherAttendance;
use App\Models\Campus;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeacherAttendanceController extends Controller
{
    /**
     * @param Attendances\GetTeacherRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Attendances\GetTeacherRequest $request, Campus $campus)
    {
        try {

            $teachers = $campus->teachers();

            $date = $request->get('date');

            $teachers->with([
                'attendance' => function ($query) use ($date) {
                    return $query->where('teacher_attendances.date', $date);
                },
                'attendance.status',
            ]);

            $teachers = $teachers->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.phone_number',
                'users.email',
                'users.username',
                'users.gender',
                'users.profile_picture',
            ])->get();

            return $this->respondWithSuccess([
                'teachers' => $teachers
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Attendances\SaveTeacherRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Attendances\SaveTeacherRequest $request, Campus $campus)
    {
        try {
            $teachers = $request->get('teachers');

            $date = $request->get('date');

            DB::transaction(function () use ($teachers, $date, $campus) {

                foreach ($teachers as $teacher) {

                    $record = $campus->teacherAttendances()->firstOrNew([
                        'user_id' => $teacher['id'],
                        'date' => $date
                    ]);

                    $record->attendance_status_id = $teacher['status_id'];

                    if (isset($teacher['comments'])) {
                        $record->comments = $teacher['comments'];
                    }

                    $record->save();
                }
            });

            return $this->respondWithSuccess([
                'message' => "Attendance marked successfully for date {$date}"
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Attendances\UpdateTeacherRequest $request
     * @param Campus $campus
     * @param TeacherAttendance $attendance
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Attendances\UpdateTeacherRequest $request, Campus $campus, TeacherAttendance $attendance)
    {
        try {
            $attendance->update($request->only('date', 'comments'));

            $attendance->attendance_status_id = $request->get('status_id');

            $attendance->save();

            $attendance->refresh();

            $attendance->load('status');

            return $this->respondWithSuccess([
                'attendance' => $attendance,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Attendances\TeacherOverviewRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function overview(Attendances\TeacherOverviewRequest $request, Campus $campus)
    {
        try {

            $start_date = new Carbon($request->start_date);

            $end_date = new Carbon($request->end_date);

            $teachers = $campus->teachers()->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.username',
                'users.gender',
            ])->get();

            foreach ($teachers as $teacher) {

                $teacher->load(['attendances' => function ($attendances) use ($start_date, $end_date) {
                    $attendances->with('status');
                    $attendances->whereBetween('teacher_attendances.date', [$start_date->toDateString(), $end_date->toDateString()]);
                }]);
            }

            return $this->respondWithSuccess([
                'teachers' => $teachers,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }
}
