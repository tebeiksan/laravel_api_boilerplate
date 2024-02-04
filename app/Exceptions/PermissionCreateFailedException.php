<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PermissionCreateFailedException extends Exception
{
    public $message = "Create permission failed";

    public $code = Response::HTTP_UNPROCESSABLE_ENTITY;

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
