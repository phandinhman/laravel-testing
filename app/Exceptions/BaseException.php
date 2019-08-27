<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Config;

class BaseException extends Exception
{
    private $errorCode;
    private $errorMessage;

    public function __construct($exceptionName, $errorMessage = null, $httpCode = 400, Exception $previous = null)
    {
        $this->errorCode = Config::get('api_exception.' . $exceptionName . '.error_code');
        $this->errorMessage = $errorMessage ?? Config::get('api_exception.' . $exceptionName . '.message');
        parent::__construct($this->errorMessage, $httpCode, $previous);
    }

    public function getErrorCode()
    {
        return $this->errorCode;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
