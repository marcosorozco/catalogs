<?php

namespace Marcosorozco\Catalogs\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected $errors;

    public function __construct($message, $errors = null, $code = 0, Exception $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }
    public function getErrors()
    {
        return $this->errors;
    }
}