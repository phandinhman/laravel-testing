<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Request;
use App\Exceptions\BaseException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

trait RestExceptionHandlerTrait
{

    protected function getJsonResponseForException(Exception $e)
    {
        if (config('APP_ENV') == 'local') {
            Log::error($e->getMessage());
        }
        switch (true) {
            case $this->isAuthenticationException($e):
                $rest = $this->unauthorized();
                break;
            case $this->isModelNotFoundException($e):
                $rest = $this->modelNotFound();
                break;
            case $this->isMethodNotAllowedHttpException($e):
                $rest = $this->methodNotFound();
                break;
            case $this->isBaseException($e):
                $rest = $this->handleLaravelBaseApiException($e);
                break;
            default:
                $rest = $this->badRequest($e);
        }
        return $rest;
    }

    protected function badRequest($e)
    {
        return $this->jsonResponse([
            'code' => config('api_exception.bad_request.error_code'),
            'message' => config('api_exception.bad_request.message'),
        ]);
    }


    protected function unauthorized()
    {
        return $this->jsonResponse([
            'code' => config('api_exception.unauthorized.error_code'),
            'message' => config('api_exception.unauthorized.message'),
        ]);
    }

    protected function modelNotFound()
    {
        return $this->jsonResponse([
            'code' => config('api_exception.model_not_found.error_code'),
            'message' => config('api_exception.model_not_found.message'),
        ]);
    }

    protected function methodNotFound()
    {
        return $this->jsonResponse([
            'code' => config('api_exception.method_not_found.error_code'),
            'message' => config('api_exception.method_not_found.message'),
        ]);
    }

    protected function handleLaravelBaseApiException(BaseException $exception)
    {
        return $this->jsonResponse([
            'code' => $exception->getErrorCode(),
            'message' => $exception->getErrorMessage(),
        ]);
    }

    protected function jsonResponse(array $payload = null, $statusCode = 400)
    {
        $response = [
            'success' => false,
            'error' => $payload,
        ];
        return response()->json($response, $statusCode);
    }

    protected function isModelNotFoundException(Exception $e)
    {
        return $e instanceof ModelNotFoundException;
    }

    protected function isMethodNotAllowedHttpException(Exception $e)
    {
        return $e instanceof MethodNotAllowedHttpException;
    }

    protected function isAuthenticationException(Exception $e)
    {
        return $e instanceof AuthenticationException;
    }

    protected function isBaseException(Exception $e)
    {
        return $e instanceof BaseException;
    }
}
