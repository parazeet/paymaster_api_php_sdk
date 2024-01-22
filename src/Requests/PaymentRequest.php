<?php

namespace parazeet\PayMaster\Requests;

use parazeet\PayMaster\Responses\PaymentResponse;

class PaymentRequest extends Request
{
    protected string $merchantId;
    protected bool $dualMode;
    protected bool $testMode;
    protected array $tokenization;
    protected array $invoice;
    protected array $amount;
    protected array $paymentData;
    protected array $protocol;
    protected array $customer;
    protected array $device;
    protected array $receipt;
    protected array $completeData;
    protected array $confirmData;
    private string $uri = 'payments';
    private string $response = PaymentResponse::class;

    public function __construct()
    {
        parent::__construct($this->uri, $this->response);
    }

    public function merchantId(string $merchantId) //required
    {
        $this->merchantId = $merchantId;    //required string	Идентификатор магазина

        return clone $this;
    }

    public function dualMode(bool $dualMode)
    {
        $this->dualMode = $dualMode;    //bool	Флаг DMS платежа (по-умолчанию false)

        return clone $this;
    }

    public function testMode(bool $testMode)
    {
        $this->testMode = $testMode;    //bool	Флаг тестового платежа (по-умолчанию false)

        return clone $this;
    }

    public function tokenization(array $tokenization)
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

    public function invoice(array $invoice) //required
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

    public function amount(array $amount) //required
    {
        $this->amount = [
            'value' => $amount['value'],    //required decimal	Сумма к оплате
            'currency' => $amount['currency'], //required string	Код валюты
        ];

        return clone $this;
    }

    public function paymentData(array $paymentData) //required Платежные данные
    {
        if (array_key_exists('paymentMethod', $paymentData)) {
            $this->paymentData = [
                'paymentMethod' => $paymentData['paymentMethod'] //string	Способ оплаты - bankcard/sbp/qiwi
            ];
        }

        if (array_key_exists('card', $paymentData)) {
            $this->paymentData['card'] = [  //Данные карты;
                'pan' => $paymentData['card']['pan'],    //required string	Номер карты
                'expiry' => $paymentData['card']['expiry'],    //required string	Срок действия
            ];

            if (array_key_exists('cvc', $paymentData['card'])) {
                $this->paymentData['card']['cvc'] = $paymentData['card']['cvc'];   //string	CVV/CVC2
            }

            if (array_key_exists('dsrp', $paymentData['card'])) {
                $this->paymentData['card']['dsrp'] = [  //Данные карты;
                    'type' => $paymentData['card']['dsrp']['type'],    //required string	Тип (ApplePay / GooglePay)
                    'cryptogram' => $paymentData['card']['dsrp']['cryptogram'],    //required string	Cryptogram  
                ];

                if (array_key_exists('eci', $paymentData['card']['dsrp'])) {
                    $this->paymentData['card']['dsrp']['eci'] = $paymentData['card']['dsrp']['eci'];    //string	ECI
                }
            }
        }

        if (array_key_exists('authorizationCode', $paymentData)) {  //string	Код авторизации платежа
            $this->paymentData['authorizationCode'] = $paymentData['authorizationCode'];
        }

        if (array_key_exists('account', $paymentData)) {  //string	Логин/аккаунт
            $this->paymentData['account'] = $paymentData['account'];
        }

        if (array_key_exists('phone', $paymentData)) {  //string	Номер телефона
            $this->paymentData['phone'] = $paymentData['phone'];
        }

        if (array_key_exists('token', $paymentData)) {  //Платежный токен
            if (array_key_exists('id', $paymentData['token'])) {
                $this->paymentData['token'] = [
                    'id' => $paymentData['token']['id'] //required string	Идентификатор токена
                ];
            }
        }

        if (array_key_exists('stickerId', $paymentData)) {  //string	Идентификатор стикера (кассовой ссылки)
            $this->paymentData['stickerId'] = $paymentData['stickerId'];
        }

        return clone $this;
    }

    public function protocol(array $protocol)
    {
        if (array_key_exists('returnUrl', $protocol)) {
            $this->protocol['returnUrl'] = $protocol['returnUrl']; //string	Страница, на которую нужно направить пользователя после оплаты
        }

        if (array_key_exists('callbackUrl', $protocol)) {
            $this->protocol['callbackUrl'] = $protocol['callbackUrl']; //url для нотификации об оплате
        }

        return clone $this;
    }

    public function customer(array $customer)
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

    public function device(array $device)
    {
        $this->device = [   //Сведения об устройстве пользователя
            'language' => $device['language'],    //required string	Язык
            'acceptHeader' => $device['acceptHeader'],    //required string	Значение заголовка Accept
            'userAgent' => $device['userAgent'],    //required string	Значение заголовка UserAgent
            'colorDepth' => $device['colorDepth'],    //required tring	Глубина цветовой палитры в битах
            'screenHeight' => $device['screenHeight'],    //required string	Высота экрана в пикселах
            'screenWidth' => $device['screenWidth'],    //required string	Ширина экрана в пикселах
            'utcOffsetMinutes' => $device['utcOffsetMinutes'],    //required string	Смещение от UTC в минутах
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

    public function completeData(array $data)
    {
        $this->completeData = [
            'id' => $data['id']	//required string	Идентификатор платежа
        ];

        if (array_key_exists('code', $data)) {
            $this->completeData['code'] = $data['code']; //string	e-mail пользователя
        }
        if (array_key_exists('threeDSCompInd', $data)) {
            $this->completeData['threeDSCompInd'] = $data['threeDSCompInd']; //string	3DS Method complete indicator
        }
        if (array_key_exists('cres', $data)) {
            $this->completeData['cres'] = $data['cres']; //string	Challenge response
        }
        if (array_key_exists('PARes', $data)) {
            $this->completeData['PARes'] = $data['PARes']; //string Payer Authentication response
        }

        return clone $this;
    }

    public function confirmData(array $data)
    {
        $this->confirmData = [
            'id' => $data['id']	//required string	Идентификатор платежа
        ];

        if (array_key_exists('amount', $data)) {    //required Сумма списания
            $this->confirmData['value'] = $data['value']; //required decimal	Сумма списания
            $this->confirmData['currency'] = $data['currency']; //required string	Код валюты
        }
        if (array_key_exists('receipt', $data)) {  //Данные чека
            $this->confirmData['client'] = $data['threeDSCompInd']; //Данные покупателя
            $this->confirmData['items'] = $data['threeDSCompInd']; //Перечисление позиций чека
        }

        return clone $this;
    }

    public function toArray(): array
    {
        $result = [
            "merchantId" => $this->merchantId,
            "invoice" => $this->invoice,
            "amount" => $this->amount,
            "paymentData" => $this->paymentData
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

        if (!empty($this->protocol)) {
            $result["protocol"] = $this->protocol;
        }

        if (!empty($this->customer)) {
            $result["customer"] = $this->customer;
        }

        if (!empty($this->device)) {
            $result["device"] = $this->device;
        }

        if (!empty($this->receipt)) {
            $result["receipt"] = $this->receipt;
        }

        return $result;
    }
}
