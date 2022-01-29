<?php

namespace main\models\exceptions;

use Throwable;

class CommandException extends BaseException
{
    const CODE = 1;


    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, self::CODE, $previous);
    }
}