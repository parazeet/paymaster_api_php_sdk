<?php

namespace parazeet\PayMaster\Requests;

use parazeet\PayMaster\Responses\TokenizationResponse;

class TokenizationRequest extends Request
{
    protected string $merchantId;
    protected bool $testMode;
    protected string $type;
    protected string $purpose;
    protected string $paymentMethod;
    protected string $callbackUrl;
    protected string $returnUrl;
    protected array $customer;
    private string $uri = 'tokenization';
    private string $response = TokenizationResponse::class;

    public function __construct()
    {
        parent::__construct($this->uri, $this->response);
    }

    public function merchantId(string $merchantId) //required
    {
        $this->merchantId = $merchantId;    //required string	Идентификатор магазина

        return clone $this;
    }

    public function testMode(bool $testMode)
    {
        $this->testMode = $testMode;    //bool Флаг тестового режима (по-умолчанию false)

        return clone $this;
    }

    public function type(string $type) //required
    {
        $this->type = $type;    //string	Тип платежного токена (recurring)

        return clone $this;
    }

    public function purpose(string $purpose) //required
    {
        $this->purpose = $purpose;  //string	Описание подписки

        return clone $this;
    }

    public function paymentMethod(string $paymentMethod) //required
    {
        $this->paymentMethod = $paymentMethod;  //string	Способ оплаты - bankcard,sbp,qiwi

        return clone $this;
    }

    public function callbackUrl(string $callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;  //string	url для нотификаций по статусу токена

        return clone $this;
    }

    public function returnUrl(string $returnUrl)
    {
        $this->returnUrl = $returnUrl;  //string	url для возврата пользователя

        return clone $this;
    }

    public function customer(array $customer) //required
    {
        $this->customer['account'] = $customer['account'];  //Аккаунт пользователя в магазине

        if (array_key_exists('email', $customer)) {
            $this->customer['email'] = $customer['email']; //string e-mail пользователя
        }

        return clone $this;
    }

    public function toArray(): array
    {
        $result = [
            "merchantId" => $this->merchantId,
            "type" => $this->type,
            "purpose" => $this->purpose,
            "paymentMethod" => $this->paymentMethod,
            "customer" => $this->customer,
        ];

        if (!empty($this->testMode)) {
            $result["testMode"] = $this->testMode;
        }

        if (!empty($this->callbackUrl)) {
            $result["callbackUrl"] = $this->callbackUrl;
        }

        if (!empty($this->returnUrl)) {
            $result["returnUrl"] = $this->returnUrl;
        }

        return $result;
    }
}
