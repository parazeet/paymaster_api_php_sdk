<?php

namespace parazeet\PayMaster\Requests;

use parazeet\PayMaster\Responses\RefundResponse;

class RefundRequest extends Request
{
    protected string $paymentId;
    protected array $amount;
    protected array $receipt;
    private string $uri = 'refunds';
    private string $response = RefundResponse::class;

    public function __construct()
    {
        parent::__construct($this->uri, $this->response);
    }

    public function paymentId(string $paymentId) //required
    {
        $this->paymentId = $paymentId;    //required string	Идентификатор платежа

        return clone $this;
    }

    public function amount(array $amount) //required Сумма возврата
    {
        $this->amount = [
            'value' => $amount['value'],    //required decimal	Сумма возврата
            'currency' => $amount['currency'], //required string	Код валюты
        ];

        return clone $this;
    }

    public function receipt(array $receipt)
    {
        $this->receipt = [
            'client' => $receipt['client'],    //required Данные покупателя
            'items' => $receipt['items'],    //required Перечисление позиций чека
        ];

        return clone $this;
    }

    public function toArray(): array
    {
        $result = [
            "paymentId" => $this->paymentId,
            "amount" => $this->amount,
        ];

        if (!empty($this->receipt)) {
            $result["receipt"] = $this->receipt;
        }

        return $result;
    }
}
