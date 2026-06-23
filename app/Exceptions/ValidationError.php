<?php
// app/Exceptions/ValidationError.php

namespace App\Exceptions;

use Exception;

class ValidationError extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}