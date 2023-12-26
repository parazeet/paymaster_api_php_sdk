<?php

namespace parazeet\PayMaster\Requests;

use parazeet\PayMaster\Responses\Response;

abstract class Request
{
    public function __construct(
        private string  $uri,
        private string  $response,
    ) {
    }

    public function toArray(): array
    {
        return [];
    }

    public function getUri(): string
    {
        return "{$this->uri}/";
    }

    public function createResponse(...$response): Response
    {
        return $this->response::fromResponse(...$response);
    }
}
