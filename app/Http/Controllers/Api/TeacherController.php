<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Teachers;
use App\Models\Campus;
use App\Models\Section;
use App\Models\Teacher;
use App\Services\Users\RegisterService;
use App\Services\Users\UpdateService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherController extends Controller
{
    /**
     * @param Teachers\GetRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Teachers\GetRequest $request, Campus $campus)
    {
        try {

            if ($request->has('section_id')) {

                $section_id = $request->get('section_id');

                $section = Section::find($section_id);

                if ($section->grade->campus_id != $campus->id) {
                    throw new \Exception("Section id is invalid", 400);
                }

                $teachers = $section->teachers()->ofCampus($campus);
            } else {
                $teachers = $campus->teachers();
            }

            if (!empty($request->get('query'))) {
                $teachers->searchOnFields([
                    'first_name',
                    'middle_name',
                    'last_name',
                    'email',
                    'username'
                ], $request->get('query'));
            }

            $teachers = $teachers->paginate(20);

            return $this->respondWithSuccess([
                'teachers' => $teachers,
            ]);

        } catch (\Exception $exception) {

            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Teachers\StoreRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Teachers\StoreRequest $request, Campus $campus)
    {
        try {
            $service = new RegisterService($request->all());
            $service->setCreatedBy($request->user())
                ->setCampus($campus);

            $teacher = $service->createTeacher();

            return $this->respondWithSuccess([
                'teacher' => $teacher,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }


    /**
     * @param Teachers\ShowRequest $request
     * @param Campus $campus
     * @param Teacher $teacher
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Teachers\ShowRequest $request, Campus $campus, Teacher $teacher)
    {

        $sectionAssignments = $teacher->sectionAssignments()->get();

        $sections = [];

        foreach ($sectionAssignments as $sectionAssignment) {

            $section = $sectionAssignment->section;
            $section->subject = $sectionAssignment->subject;
            $sections[] = $section;
        }

        $response = $teacher->toArray();

        $response['sections'] = $sections;

        return $this->respondWithSuccess([
            'teacher' => $response,
        ]);
    }

    /**
     * @param Teachers\UpdateRequest $request
     * @param Campus $campus
     * @param Teacher $teacher
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Teachers\UpdateRequest $request, Campus $campus, Teacher $teacher)
    {
        try {
            $service = new UpdateService($campus, $teacher, $request->user(), $request->all());
            $teacher = $service->updateTeacher();


            return $this->respondWithSuccess([
                'teacher' => $teacher,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Teachers\DeleteRequest $request
     * @param Campus $campus
     * @param Teacher $teacher
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Teachers\DeleteRequest $request, Campus $campus, Teacher $teacher)
    {
        try {

            $teacher->sectionAssignments()->delete();
            $teacher->campus_id = null;
            $teacher->section_id = null;
            $teacher->save();

            return $this->respondWithSuccess([
                'message' => 'Teacher un-register successfully',
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }
}
