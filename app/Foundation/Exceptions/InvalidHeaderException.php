<?php

namespace App\Foundation\Exceptions;

use Exception;

class InvalidHeaderException extends Exception
{
    protected $message = 'Invalid Header';
    protected $code = 400;
}
