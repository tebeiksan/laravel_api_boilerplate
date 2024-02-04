<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class InvalidAccessTokenException extends Exception
{
    public $message = 'Invalid access token';

    public $code = Response::HTTP_UNAUTHORIZED;

    public $data = [];

    public function __construct($message = null, $code = null, $request = [])
    {
        $this->message = $message ? $message : $this->message;

        $this->data = $request;

        if ($code) {
            $this->code = $code;
        }

        parent::__construct($this->message, $this->code);
    }
}
