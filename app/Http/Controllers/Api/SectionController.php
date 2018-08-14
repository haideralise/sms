<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Sections;
use App\Models\Grade;
use App\Models\Section;
use App\Http\Controllers\Controller;
use function foo\func;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    /**
     * @param Sections\GetRequest $request
     * @param Grade $grade
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Sections\GetRequest $request, Grade $grade)
    {
        try {

            $grades = $grade->sections()->with('subjects')->get();

            return $this->respondWithSuccess([
                'sections' => $grades,
            ]);

        } catch (\Exception $exception) {

            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Sections\StoreRequest $request
     * @param Grade $grade
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Sections\StoreRequest $request, Grade $grade)
    {
        try {

            $section = $grade->sections()->create($request->all());
            $section->created_by = $request->user()->id;
            $section->save();

            $section->refresh();

            return $this->respondWithSuccess([
                'section' => $section,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Sections\UpdateRequest $request
     * @param Grade $grade
     * @param Section $section
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Sections\UpdateRequest $request, Grade $grade, Section $section)
    {
        try {

            $section->update($request->all());

            $section->refresh();

            return $this->respondWithSuccess([
                'section' => $section,
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Sections\DeleteRequest $request
     * @param Grade $grade
     * @param Section $section
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Sections\DeleteRequest $request, Grade $grade, Section $section)
    {
        try {

            $section->delete();

            return $this->respondWithSuccess([
                'message' => 'Section Deleted successfully',
            ]);

        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Sections\SyncSubjectRequest $request
     * @param Section $section
     * @return \Illuminate\Http\JsonResponse
     */
    public function syncSubjects(Sections\SyncSubjectRequest $request, Section $section)
    {
        try {

            $subjects = collect($request->get('subjects'));

            $section1 = DB::transaction(function () use ($subjects, $section) {

                $section->subjects()->sync($subjects->pluck('id'));

                return $section;

            });


            $section1->load('subjects');

            return $this->respondWithSuccess([
                'section' => $section1
            ]);
        } catch (\Exception $exception) {

            return $this->responseWithException($exception);
        }
    }

    /**
     * @param Sections\DeleteRequest $request
     * @param Grade $grade
     * @param Section $section
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Sections\DeleteRequest $request, Grade $grade, Section $section)
    {
        $section->load('subjects');

        return $this->respondWithSuccess([
            'section' => $section,
        ]);
    }
}
