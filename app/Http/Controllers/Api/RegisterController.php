<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\Controller;
use App\Services\RegisterService;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function web(RegisterRequest $request)
    {
        try {

            $service = new RegisterService($request->all());

            $user = $service->call();

            $token = JWTAuth::fromUser($user);

            return $this->respondWithSuccess([
                'token' => $token,
                'school' => $user->schools()->with('campuses')->first(),
            ]);

        } catch (\Exception $exception) {

            return $this->responseWithException($exception);
        }
    }
}
