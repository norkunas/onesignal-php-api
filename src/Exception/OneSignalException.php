<?php
namespace OneSignal\Exception;

class OneSignalException extends \RuntimeException
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var array
     */
    protected $errors;

    /**
     * Constructor.
     *
     * @param int        $statusCode HTTP Status Code
     * @param array      $errors     [optional] Errors list
     * @param string     $message    [optional] The Exception message to throw
     * @param int        $code       [optional] The Exception code
     * @param \Exception $previous   [optional] The previous exception used for the exception chaining
     */
    public function __construct($statusCode, $errors = [], $message = '', $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $statusCode;
        $this->errors = $errors;
    }

    /**
     * Get http status code.
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Get errors list.
     *
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
