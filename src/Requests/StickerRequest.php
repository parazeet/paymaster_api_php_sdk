<?php

namespace parazeet\PayMaster\Requests;

use parazeet\PayMaster\Responses\StickerResponse;

class StickerRequest extends Request
{
    protected string $merchantId;
    protected string $stickerType;
    protected bool $cashlink;
    protected string $description;
    protected string $productCode;
    protected string $paymentPurpose;
    protected array $amount;
    protected string $callbackUrl;
    protected bool $active;
    private string $uri = 'stickers';
    private string $response = StickerResponse::class;

    public function __construct()
    {
        parent::__construct($this->uri, $this->response);
    }

    public function merchantId(string $merchantId) //required
    {
        $this->merchantId = $merchantId;    //required string	Идентификатор магазина

        return clone $this;
    }

    public function stickerType(string $stickerType) //required
    {
        $this->stickerType = $stickerType;    //string	Тип стикера (например, Sbp)

        return clone $this;
    }

    public function cashlink(bool $cashlink)
    {
        $this->cashlink = $cashlink;    //bool	Признак кассовой ссылки

        return clone $this;
    }

    public function description(string $description)
    {
        $this->description = $description;    //string	Описание стикера

        return clone $this;
    }

    public function productCode(string $productCode)
    {
        $this->productCode = $productCode;    //string	Код продукта

        return clone $this;
    }

    public function paymentPurpose(string $paymentPurpose)
    {
        $this->paymentPurpose = $paymentPurpose;    //string	Назначение платежа

        return clone $this;
    }

    public function amount(array $amount)
    {
        $this->amount = [
            'value' => $amount['value'],    //required decimal	Сумма к оплате
            'currency' => $amount['currency'], //required string	Код валюты
        ];

        return clone $this;
    }

    public function callbackUrl(string $callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;    //string	url для нотификации об оплате

        return clone $this;
    }

    public function active(bool $active)
    {
        $this->active = $active;    //bool	Статус стикера

        return clone $this;
    }

    public function toArray(): array
    {
        if (!empty($this->merchantId)) {
            $result["merchantId"] = $this->merchantId;
        }
        if (!empty($this->stickerType)) {
            $result["stickerType"] = $this->stickerType;
        }
        if (!empty($this->paymentPurpose)) {
            $result["paymentPurpose"] = $this->paymentPurpose;
        }
        if (!empty($this->cashlink)) {
            $result["cashlink"] = $this->cashlink;
        }
        if (!empty($this->description)) {
            $result["description"] = $this->description;
        }
        if (!empty($this->productCode)) {
            $result["productCode"] = $this->productCode;
        }
        if (!empty($this->amount)) {
            $result["amount"] = $this->amount;
        }
        if (!empty($this->callbackUrl)) {
            $result["callbackUrl"] = $this->callbackUrl;
        }
        if (!empty($this->active)) {
            $result["active"] = $this->active;
        }

        return $result;
    }
}
