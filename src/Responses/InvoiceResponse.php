<?php

namespace parazeet\PayMaster\Responses;

use parazeet\PayMaster\Models\Invoice;

class InvoiceResponse implements Response
{
    public function __construct()
    {
    }

    public static function fromResponse($response): self
    {
        return new self(
            new Invoice(
                $response['paymentId'],
                $response['url']
            )
        );
    }
}
