<?php

namespace App\Exception;

use Exception;

class ValidationException extends Exception
{
    private $error;

    public function __construct(string $error, string $field)
    {
        $this->error = "In field `$field`, message: $error. Thrown in: " . static::class;
        parent::__construct("validation_error");
    }

    public function getError()
    {
        return $this->error;
    }
}