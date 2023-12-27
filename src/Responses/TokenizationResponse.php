<?php

namespace parazeet\PayMaster\Responses;

use parazeet\PayMaster\Models\Tokenization;

class TokenizationResponse implements Response
{
    public function __construct(
        public object $tokenization,
    ){}

    public static function fromResponse($response): self
    {
        return new self(new Tokenization(
            $response['tokenId'],
            $response['url']
        ));
    }
}
