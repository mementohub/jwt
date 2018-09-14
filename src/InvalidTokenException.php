<?php

namespace iMemento\JWT;

use Exception;

class InvalidTokenException extends Exception
{
    /**
     *
     * @param string     $message
     * @param int        $code
     * @param \Exception $previous
     */
    public function __construct($message = null, $code = 1001, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}