<?php

namespace parazeet\PayMaster\Models;

class Tokenization
{
    public function __construct(
        public ?string $tokenId,
        public ?string $url,
    ) {
    }
}