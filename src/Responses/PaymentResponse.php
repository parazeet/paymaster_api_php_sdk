<?php

namespace parazeet\PayMaster\Responses;

use parazeet\PayMaster\Models\Payment;

class PaymentResponse implements Response
{
    public function __construct(
        public object|array $payments,
    ){}

    public static function fromResponse($response): self
    {
        if (array_is_list($response)) {
            return new self(self::getModelList($response));
        } else {
            return new self(self::getModelArray($response));
        }
    }

    protected static function getModelList($response): array
    {
        return array_map(fn($key, $response) => new Payment(
            $response['id'],
            $response['created'],
            $response['testMode'],
            $response['status'],
            $response['resultCode'] ?? null,
            $response['message'] ?? null,
            $response['merchantId'],
            $response['amount'],
            $response['invoice'],
            $response['paymentData'] ?? null,
            $response['confirmation'] ?? null,
            $response['paymentToken'] ?? null
        ), array_keys($response), array_values($response));
    }

    protected static function getModelArray($response): Payment
    {
        return new Payment(
            $response['id'],
            $response['created'],
            $response['testMode'],
            $response['status'],
            $response['resultCode'] ?? null,
            $response['message'] ?? null,
            $response['merchantId'],
            $response['amount'],
            $response['invoice'],
            $response['paymentData'] ?? null,
            $response['confirmation'] ?? null,
            $response['paymentToken'] ?? null,
        );
    }
}
