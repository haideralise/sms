<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $response;

    protected $statusCode = 200;

    /**
     * @param $data
     * @param $code
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $code, $headers = [])
    {
        return response()->json($data, $code, $headers);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not found')
    {
        return $this->setStatusCode(404)->respondWithError($message);
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal Error')
    {
        return $this->respond([
            'error' => $message,
        ], 500);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => $message,
        ], $this->getStatusCode());
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithSuccess($data)
    {
        return $this->respond($data, $this->getStatusCode());
    }

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param \Exception $exception
     */
    public function logError(\Exception $exception)
    {
        Log::error(implode('|', [
                $exception->getFile(),
                $exception->getLine(),
                $exception->getCode(),
                $exception->getMessage(),
                get_class($this),
            ])
        );
    }

    public function responseWithException(\Exception $exception)
    {
        $this->logError($exception);

        if ($exception->getCode() >= 400 && $exception->getCode() < 500) {
            return $this->setStatusCode($exception->getCode())
                ->respondWithError($exception->getMessage());
        } else {
            return $this->respondInternalError($exception->getMessage());
        }
    }
}
