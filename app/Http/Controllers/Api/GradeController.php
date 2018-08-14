<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Grades;
use App\Models\Campus;
use App\Models\Grade;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    /**
     * @param Grades\GetRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Grades\GetRequest $request, Campus $campus)
    {
        try {

            $grades = $campus->grades()->with('sections', 'sections.subjects')->get();

            return $this->respondWithSuccess([
                'grades' => $grades,
            ]);

        } catch (\Exception $exception) {

            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Grades\StoreRequest $request
     * @param Campus $campus
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Grades\StoreRequest $request, Campus $campus)
    {
        try {

            $info = $request->all();
            $user = $request->user();

            $grade = DB::transaction(function () use ($campus, $user, $info) {

                $grade = $campus->grades()->create($info);
                $grade->created_by = $user->id;
                $grade->save();

                if (isset($info['sections'])) {
                    $sections = $info['sections'];

                    foreach ($sections as $section) {
                        $section = $grade->sections()->create($section);
                        $section->created_by = $user->id;
                        $section->save();
                    }
                }

                return $grade;
            });

            $grade->refresh();

            $grade->load('sections');

            return $this->respondWithSuccess([
                'grade' => $grade,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Grades\UpdateRequest $request
     * @param Campus $campus
     * @param Grade $grade
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Grades\UpdateRequest $request, Campus $campus, Grade $grade)
    {
        try {

            $grade->update($request->all());

            $grade->refresh();
            $grade->load('sections');

            return $this->respondWithSuccess([
                'grade' => $grade,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Grades\DeleteRequest $request
     * @param Campus $campus
     * @param Grade $grade
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Grades\DeleteRequest $request, Campus $campus, Grade $grade)
    {
        try {

            $grade->delete();

            return $this->respondWithSuccess([
                'message' => 'Grade Deleted successfully',
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }
}
