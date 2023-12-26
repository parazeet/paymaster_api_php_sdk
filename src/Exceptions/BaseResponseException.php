<?php

namespace parazeet\PayMaster\Exceptions;

class BaseResponseException extends \Exception
{
    protected $code;

    public function __construct(string $message, string $code)
    {
        $this->code = $code;

        parent::__construct($message, 0, null);
    }

    public function code(): string
    {
        return $this->code;
    }
}