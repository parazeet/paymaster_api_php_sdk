<?php

namespace parazeet\PayMaster\Responses;

use parazeet\PayMaster\Models\Receipt;

class ReceiptResponse implements Response
{
    public function __construct(
        public object|array $receipt,
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
        return array_map(fn($key, $response) => new Receipt(
            $response['id'],
            $response['created'],
            $response['paymentId'],
            $response['amount'],
            $response['type'],
            $response['status'],

        ), array_keys($response), array_values($response));
    }

    protected static function getModelArray($response): Receipt
    {
        return new Receipt(
            $response['id'],
            $response['created'],
            $response['paymentId'],
            $response['amount'],
            $response['type'],
            $response['status'],
        );
    }
}
