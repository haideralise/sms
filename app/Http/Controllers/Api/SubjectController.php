<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sections\GetSubjectsRequest;
use App\Http\Requests\Subjects;
use App\Models\Campus;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * @param Subjects\GetRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Subjects\GetRequest $request, Campus $campus)
    {
        try {

            $grades = $campus->subjects()->get();

            return $this->respondWithSuccess([
                'subjects' => $grades,
            ]);

        } catch (\Exception $exception) {

            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Subjects\StoreRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Subjects\StoreRequest $request, Campus $campus)
    {
        try {

            $info = $request->all();
            $user = $request->user();

            $subject = DB::transaction(function () use ($campus, $user, $info) {

                $subject = $campus->subjects()->create($info);
                $subject->created_by = $user->id;
                $subject->save();


                return $subject;
            });

            $subject->refresh();

            return $this->respondWithSuccess([
                'subject' => $subject,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Subjects\UpdateRequest $request
     * @param Campus $campus
     * @param Subject $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Subjects\UpdateRequest $request, Campus $campus, Subject $subject)
    {
        try {

            $subject->update($request->all());

            $subject->refresh();

            return $this->respondWithSuccess([
                'subject' => $subject,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Subjects\DeleteRequest $request
     * @param Campus $campus
     * @param Subject $subject
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Subjects\DeleteRequest $request, Campus $campus, Subject $subject)
    {
        try {

            $subject->delete();

            return $this->respondWithSuccess([
                'message' => 'Subject Deleted successfully',
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param GetSubjectsRequest $request
     * @param Section $section
     * @return \Illuminate\Http\JsonResponse
     */
    public function sectionSubjects(GetSubjectsRequest $request, Section $section)
    {
        $subjects = $section->subjects()->get();

        return $this->respondWithSuccess([
            'subjects' => $subjects,
        ]);
    }
}
