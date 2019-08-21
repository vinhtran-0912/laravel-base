<?php
namespace App\Exceptions;

use Config;
use Exception;

class HousecomApiException extends Exception
{
    private $errorCode;
    private $errorMessage;

    /**
     * HousecomApiException constructor
     *
     * @param  int $errorCode
     * @param  string $errorMessage
     * @param  int $httpCode
     * @param  Exception $previous
     *
     * @return void
     */
    public function __construct($exceptionName, $errorMessage = null, $httpCode = 400, Exception $previous = null)
    {
        $this->errorCode = Config::get('api_exception.' . $exceptionName . '.error_code');
        $this->errorMessage = $errorMessage ?? Config::get('api_exception.' . $exceptionName . '.message');
        parent::__construct($this->errorMessage, $httpCode, $previous);
    }

    /**
     * Get error code
     *
     * @return int
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * getErrorMessage
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }
}
