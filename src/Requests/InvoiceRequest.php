<?php

namespace parazeet\PayMaster\Requests;

use parazeet\PayMaster\Responses\InvoiceResponse;

class InvoiceRequest extends Request
{
    protected string $merchantId;
    protected bool $dualMode;
    protected bool $testMode;
    protected array $tokenization;
    protected array $invoice;
    protected array $amount;
    protected string $paymentMethod;
    protected array $protocol;
    protected array $customer;
    protected array $receipt;
    private string $uri = 'invoices';
    private string $response = InvoiceResponse::class;

    public function __construct()
    {
        parent::__construct($this->uri, $this->response);
    }

    public function merchantId(string $merchantId): InvoiceRequest|static //required
    {
        $this->merchantId = $merchantId;    //required string	Идентификатор магазина

        return clone $this;
    }

    public function dualMode(bool $dualMode): InvoiceRequest|static
    {
        $this->dualMode = $dualMode;    //bool	Флаг DMS платежа (по-умолчанию false)

        return clone $this;
    }

    public function testMode(bool $testMode): InvoiceRequest|static
    {
        $this->testMode = $testMode;    //bool	Флаг тестового платежа (по-умолчанию false)

        return clone $this;
    }

    public function tokenization(array $tokenization): InvoiceRequest|static
    {
        $this->tokenization = [
            'type' => $tokenization['type'],    //required string Тип платежного токена (cof / recurring)
        ];

        if (array_key_exists('purpose', $tokenization)) {
            $this->tokenization['purpose'] = $tokenization['purpose']; //string Описание подписки
        }

        if (array_key_exists('callbackUrl', $tokenization)) {
            $this->tokenization['callbackUrl'] = $tokenization['callbackUrl'];  //string url для нотификаций по статусу токена
        }

        return clone $this;
    }

    public function invoice(array $invoice): InvoiceRequest|static //required
    {
        $this->invoice = [
            'description' => $invoice['description'],  //required string	Назначение платежа
        ];

        if (array_key_exists('orderNo', $invoice)) {
            $this->invoice['orderNo'] = $invoice['orderNo']; //string	Номер заказа в системе магазина
        }

        if (array_key_exists('expires', $invoice)) {
            $this->invoice['expires'] = $invoice['expires']; //date	Срок действия счета
        }

        if (array_key_exists('params', $invoice)) {
            $this->invoice['params'] = $invoice['params'];
        }

        return clone $this;
    }

    public function amount(array $amount): InvoiceRequest|static //required
    {
        $this->amount = [
            'value' => $amount['value'],    //required decimal	Сумма к оплате
            'currency' => $amount['currency'], //required string	Код валюты
        ];

        return clone $this;
    }

    public function paymentMethod(string $paymentMethod): InvoiceRequest|static
    {
        $this->paymentMethod = $paymentMethod;   //string	bankcard/sbp/qiwi

        return clone $this;
    }

    public function protocol(array $protocol): InvoiceRequest|static
    {
        if (array_key_exists('returnUrl', $protocol)) {
            $this->protocol['returnUrl'] = $protocol['returnUrl']; //string	Страница, на которую нужно направить пользователя после оплаты
        }

        if (array_key_exists('callbackUrl', $protocol)) {
            $this->protocol['callbackUrl'] = $protocol['callbackUrl']; //url для нотификации об оплате
        }

        return clone $this;
    }

    public function customer(array $customer): InvoiceRequest|static
    {
        if (array_key_exists('email', $customer)) {
            $this->customer['email'] = $customer['email']; //string	e-mail пользователя
        }
        if (array_key_exists('phone', $customer)) {
            $this->customer['phone'] = $customer['phone']; //string	Телефон пользователя
        }
        if (array_key_exists('ip', $customer)) {
            $this->customer['ip'] = $customer['ip']; //string	IP-адрес пользователя
        }
        if (array_key_exists('account', $customer)) {
            $this->customer['account'] = $customer['account']; //string	Аккаунт пользователя в магазине
        }

        return clone $this;
    }

    public function receipt(array $receipt): InvoiceRequest|static
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
            "merchantId" => $this->merchantId,
            "invoice" => $this->invoice,
            "amount" => $this->amount,
        ];

        if (!empty($this->dualMode)) {
            $result["dualMode"] = $this->dualMode;
        }

        if (!empty($this->testMode)) {
            $result["testMode"] = $this->testMode;
        }

        if (!empty($this->tokenization)) {
            $result["tokenization"] = $this->tokenization;
        }

        if (!empty($this->paymentMethod)) {
            $result["paymentMethod"] = $this->paymentMethod;
        }

        if (!empty($this->protocol)) {
            $result["protocol"] = $this->protocol;
        }

        if (!empty($this->customer)) {
            $result["customer"] = $this->customer;
        }

        if (!empty($this->receipt)) {
            $result["receipt"] = $this->receipt;
        }

        return $result;
    }
}
