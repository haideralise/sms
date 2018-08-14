<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Students;
use App\Models\Campus;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\Users\RegisterService;
use App\Services\Users\UpdateService;

class StudentController extends Controller
{
    /**
     * @param Students\GetRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Students\GetRequest $request, Campus $campus)
    {
        try {

            $students = $campus->students();

            if (!empty($request->get('query'))) {
                $students->searchOnFields([
                    'first_name',
                    'middle_name',
                    'last_name',
                    'email',
                    'username'
                ], $request->get('query'));
            }

            if ($request->has('section_id')) {
                $students->ofSection($request->get('section_id'));
            }

            if ($request->has('guardian_id')) {
                $students->ofGuardian($request->get('guardian_id'));
            }

            $students = $students->with('guardian')->paginate(20);

            return $this->respondWithSuccess([
                'students' => $students,
            ]);

        } catch (\Exception $exception) {

            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Students\StoreRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Students\StoreRequest $request, Campus $campus)
    {
        try {

            $service = new RegisterService($request->all());
            $service->setCreatedBy($request->user())
                ->setCampus($campus);

            $student = $service->createStudent();

            $student->load('guardian');

            return $this->respondWithSuccess([
                'student' => $student,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }


    /**
     * @param Students\ShowRequest $request
     * @param Campus $campus
     * @param Student $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Students\ShowRequest $request, Campus $campus, Student $student)
    {
        $student->load('guardian', 'section', 'section.grade');

        return $this->respondWithSuccess([
            'student' => $student
        ]);
    }

    /**
     * @param Students\UpdateRequest $request
     * @param Campus $campus
     * @param Student $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Students\UpdateRequest $request, Campus $campus, Student $student)
    {
        try {
            $service = new UpdateService($campus, $student, $request->user(), $request->all());
            $student = $service->updateStudent();

            $student->load('guardian');

            return $this->respondWithSuccess([
                'student' => $student,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Students\DeleteRequest $request
     * @param Campus $campus
     * @param Student $student
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Students\DeleteRequest $request, Campus $campus, Student $student)
    {
        try {

            $student->sectionAssignments()->delete();

            $student->campus_id = null;
            $student->section_id = null;

            $student->save();

            return $this->respondWithSuccess([
                'message' => 'User un register successfully',
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }
}
