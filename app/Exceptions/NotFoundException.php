<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    protected $message = 'Qr_Code Not Detected';
    protected $code = 400;
}
