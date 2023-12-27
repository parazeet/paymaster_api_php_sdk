<?php

namespace parazeet\PayMaster\Models;

class Sticker
{
    public function __construct(
        public ?string $id,
        public ?string $stickerType,
        public ?bool $cashlink,
        public ?string $productCode,
        public ?string $paymentPurpose,
        public ?string $description,
        public ?array $amount,
        public ?string $status,
        public ?string $payload,
    ) {
    }
}