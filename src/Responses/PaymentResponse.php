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
            return new self(self::resp_list($response));
        } else {
            return new self(self::resp_array($response));
        }
    }

    protected static function resp_list($response): array
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

    protected static function resp_array($response): Payment
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
// {
//     "id": "12769",
//     "created":"2021-09-01T08:20:00Z",
//     "testMode": false,
//     "status": "Confirmation",
//     "resultCode": "Success",
//     "merchantId": "96es4ve9-8bce-40fd-86cb-d34db393fed68",
//     "amount": {
//       "value": 10.5000,
//       "currency": "RUB"
//     },
//     "invoice": {
//       "description": "test payment",
//       "params": {
//         "BT_USR": "34"
//       }
//     },
//     "paymentData": {
//       "paymentMethod": "BankCard"
//     },
//     "confirmation": {
//       "type": "ThreeDSv1",
//       "acsUrl": "https://paymaster.ru/acs/pareq",
//       "PAReq": "eJxVUtuO0...v4BOrji7g=="
//     }
//   }