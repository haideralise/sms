<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;


class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function web(LoginRequest $request)
    {
        try {

            $login = $request->login;

            $credentials = [
                'password' => $request->password,
            ];

            if (isEmail($login)) {
                $credentials['email'] = $login;
            } else {
                $credentials['username'] = $login;
            }

            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->setStatusCode(401)->respondWithError('Invalid credentials');
            }

        } catch (JWTException $exception) {
            return $this->responseWithException($exception);
        } catch (\Exception $exception) {
            return $this->responseWithException($exception);
        }

        $user = JWTAuth::toUser($token);

        return $this->respondWithSuccess([
            'token' => $token,
            'user' => $user,
            'school' => $user->schools()->with('campuses')->first(),
        ]);
    }
}
