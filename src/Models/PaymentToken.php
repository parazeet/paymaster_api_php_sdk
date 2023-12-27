<?php

namespace parazeet\PayMaster\Models;

class PaymentToken
{
    public function __construct(
        public ?string $id,
        public ?string $status,
        public ?string $title,
        public ?string $expires,
        public ?array $cardInfo,
    ) {
    }
}