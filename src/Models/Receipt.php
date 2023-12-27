<?php

namespace parazeet\PayMaster\Models;

class Receipt
{
    public function __construct(
        public ?string $id,
        public ?string $created,
        public ?string $paymentId,
        public ?array $amount,
        public ?string $type,
        public ?string $status,
    ) {
    }
}
