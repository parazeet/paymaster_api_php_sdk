<?php

namespace parazeet\PayMaster\Responses;

use parazeet\PayMaster\Models\Sticker;

class StickerResponse implements Response
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
        return array_map(fn($key, $response) => new Sticker(
            $response['id'],
            $response['stickerType'],
            $response['cashlink'],
            $response['productCode'],
            $response['paymentPurpose'],
            $response['description'],
            $response['amount'],
            $response['status'],
            $response['payload'],
        ), array_keys($response), array_values($response));
    }

    protected static function getModelArray($response): Sticker
    {
        return new Sticker(
            $response['id'],
            $response['stickerType'],
            $response['cashlink'],
            $response['productCode'],
            $response['paymentPurpose'],
            $response['description'],
            $response['amount'],
            $response['status'],
            $response['payload'],
        );
    }
}
