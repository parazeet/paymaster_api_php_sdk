<?php

namespace parazeet\PayMaster\Requests;

use parazeet\PayMaster\Responses\TokenizationResponse;

class PaymentTokenRequest extends Request
{
    protected string $id;
    private string $uri = 'paymenttokens';
    private string $response = TokenizationResponse::class;

    public function __construct()
    {
        parent::__construct($this->uri, $this->response);
    }

    public function id(string $id) //required
    {
        $this->id = $id;    //string	Идентификатор токена

        return clone $this;
    }

    public function toArray(): array
    {
        $result = [
            "id" => $this->id,
        ];

        return $result;
    }
}
