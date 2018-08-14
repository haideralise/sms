<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Attendances;
use App\Http\Controllers\Controller;
use App\Models\Attendance\StudentAttendance;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StudentAttendanceController extends Controller
{
    /**
     * @param Attendances\GetStudentRequest $request
     * @param Section $section
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Attendances\GetStudentRequest $request, Section $section)
    {

        try {

            $students = $section->students();

            if ($request->has('subject_id')) {
                $subject_id = $request->has('subject_id');
                $students->whereHas('subjects', function ($subject) use ($subject_id) {
                    return $subject->where('subjects.id', $subject_id);
                });
            }

            $date = $request->get('date');

            $students->with([
                'attendance' => function ($query) use ($date) {
                    return $query->where('student_attendances.date', $date);
                },
                'attendance.status',
            ]);

            $students = $students->select([
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
                'students' => $students
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }


    /**
     * @param Attendances\SaveStudentRequest $request
     * @param Section $section
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Attendances\SaveStudentRequest $request, Section $section)
    {
        try {
            $students = $request->get('students');

            $date = $request->get('date');

            DB::transaction(function () use ($students, $date, $section) {
                foreach ($students as $student) {

                    $record = $section->studentAttendances()->firstOrNew([
                        'user_id' => $student['id'],
                        'date' => $date
                    ]);

                    $record->attendance_status_id = $student['status_id'];
                    if (isset($student['comments'])) {
                        $record->comments = $student['comments'];
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
     * @param Attendances\UpdateStudentRequest $request
     * @param Section $section
     * @param StudentAttendance $attendance
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Attendances\UpdateStudentRequest $request, Section $section, StudentAttendance $attendance)
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
     * @param Attendances\StudentOverviewRequest $request
     * @param Section $section
     * @return \Illuminate\Http\JsonResponse
     */
    public function overview(Attendances\StudentOverviewRequest $request, Section $section)
    {
        try {

            $start_date = new Carbon($request->start_date);
            $end_date = new Carbon($request->end_date);

            $students = $section->students()->select([
                'users.id',
                'users.first_name',
                'users.last_name',
                'users.username',
                'users.gender',
            ])->get();

            foreach ($students as $student) {

                $student->load(['attendances' => function ($attendances) use ($start_date, $end_date) {
                    $attendances->with('status');
                    $attendances->whereBetween('student_attendances.date', [$start_date->toDateString(), $end_date->toDateString()]);
                }]);
            }

            return $this->respondWithSuccess([
                'students' => $students,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }
}
