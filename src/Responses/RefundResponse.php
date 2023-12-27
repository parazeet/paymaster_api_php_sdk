<?php

namespace parazeet\PayMaster\Responses;

use parazeet\PayMaster\Models\Refund;

class RefundResponse implements Response
{
    public function __construct(
        public object $refund,
    ){}

    public static function fromResponse($response): self
    {
        return new self(new Refund(
            $response['id'],
            $response['created'],
            $response['paymentId'],
            $response['amount'],
            $response['status'],
            $response['resultCode'] ?? null,
        ));
    }
}
