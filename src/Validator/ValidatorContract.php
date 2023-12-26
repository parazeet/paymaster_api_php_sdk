<?php

namespace parazeet\PayMaster\Validator;

interface ValidatorContract
{
    public function validate(?array $response = []): void;
}