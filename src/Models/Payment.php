<?php

namespace parazeet\PayMaster\Models;

class Payment
{
    public function __construct(
        public ?string $id,
        public ?string $created,
        public ?bool $testMode,
        public ?string $status,
        public ?string $resultCode,
        public ?string $message,
        public ?string $merchantId,
        public ?array $amount,
        public ?array $invoice,
        public ?array $paymentData,
        public ?array $confirmation,
        public ?array $paymentToken,
    ) {
    }
}
