<?php

namespace parazeet\PayMaster\Responses;

use parazeet\PayMaster\Models\PaymentToken;

class PaymentTokenResponse implements Response
{
    public function __construct(
        public object $paymentToken,
    ){}

    public static function fromResponse($response): self
    {
        return new self(new PaymentToken(
            $response['id'],
            $response['status'],
            $response['title'] ?? '',
            $response['expires'] ?? '',
            $response['cardInfo'] ?? []
        ));
    }
}
