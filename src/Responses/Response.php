<?php

namespace parazeet\PayMaster\Responses;

interface Response
{
    public static function fromResponse($response): self;
}