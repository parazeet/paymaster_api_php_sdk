<?php

namespace parazeet\PayMaster\Requests;

use parazeet\PayMaster\Responses\ReceiptResponse;

class ReceiptRequest extends Request
{
    protected string $paymentId;
    protected array $amount;
    protected string $type;
    protected array $client;
    protected array $items;
    private string $uri = 'payments';
    private string $response = ReceiptResponse::class;

    public function __construct()
    {
        parent::__construct($this->uri, $this->response);
    }

    public function paymentId(string $paymentId) //required
    {
        $this->paymentId = $paymentId;    //string	Идентификатор магазина

        return clone $this;
    }

    public function amount(array $amount) //required
    {
        $this->amount = [
            'value' => $amount['value'],    //required decimal	Сумма по чеку
            'currency' => $amount['currency'], //required string	Код валюты
        ];

        return clone $this;
    }

    public function type(string $type) //required
    {
        $this->type = $type;    //string	Тип чека

        return clone $this;
    }

    public function client(array $client) //required
    {
        if (array_key_exists('email', $client)) {
            $this->client['email'] = $client['email']; //string	e-mail покупателя
        }
        if (array_key_exists('phone', $client)) {
            $this->client['phone'] = $client['phone']; //string	Телефон покупателя
        }
        if (array_key_exists('name', $client)) {
            $this->client['name'] = $client['name']; //string	Наименование компании
        }
        if (array_key_exists('inn', $client)) {
            $this->client['inn'] = $client['inn']; //string	ИНН компании
        }

        return clone $this;
    }

    public function items(array $items) //required
    {
        $this->items = [
            'name' => $items['name'],    //required string	Наименования
            'quantity' => $items['quantity'], //required decimal Количество
            'price' => $items['price'], //required decimal Цена
            'vatType' => $items['vatType'], //required string	Ставка НДС
            'paymentSubject' => $items['paymentSubject'], //required string	Предмет расчета
            'paymentMethod' => $items['paymentMethod'], //required string	Способ расчета
        ];

        if (array_key_exists('measure', $items)) {
            $this->items['measure'] = $items['measure']; //string	Единица измерения товара
        }
        if (array_key_exists('excise', $items)) {
            $this->items['excise'] = $items['excise']; //decimal	Акциз
        }
        if (array_key_exists('agentType', $items)) {
            $this->items['agentType'] = $items['agentType']; //string	Признак агента
        }

        if (array_key_exists('product', $items)) {
            if (array_key_exists('country', $items['product'])) {
                $this->items['product']['country'] = $items['product']['country']; //string	Код страны происхождения
            }
            if (array_key_exists('declaration', $items['product'])) {
                $this->items['product']['declaration'] = $items['product']['declaration']; //string	Номер таможенной декларации
            }
        }

        if (array_key_exists('marking', $items)) {
            $this->items['marking']['code'] = $items['marking']['code'];    //required string	Код товара

            if (array_key_exists('quantity', $items['marking'])) { //Дробное количество маркированного товара
                if (array_key_exists('numerator', $items['marking']['quantity'])) {
                    $this->items['marking']['quantity']['numerator'] = $items['marking']['quantity']['numerator']; //int	Числитель
                }
                if (array_key_exists('denominator', $items['marking']['quantity'])) {
                    $this->items['marking']['quantity']['denominator'] = $items['marking']['quantity']['denominator']; //int	Знаменатель
                }
            }
        }

        if (array_key_exists('supplier', $items)) { //Данные поставщика
            if (array_key_exists('name', $items['supplier'])) {
                $this->items['supplier']['name'] = $items['supplier']['name']; //string	Наименование поставщика
            }
            if (array_key_exists('inn', $items['supplier'])) {
                $this->items['supplier']['inn'] = $items['supplier']['inn']; //string	inn поставщика
            }
            if (array_key_exists('phone', $items['supplier'])) {
                $this->items['supplier']['phone'] = $items['supplier']['phone']; //string	phone поставщика
            }
        }


        return clone $this;
    }

    public function toArray(): array
    {
        $result = [
            "paymentId" => $this->paymentId,
            "amount" => $this->amount,
            "type" => $this->type,
            "client" => $this->client,
            "items" => $this->items
        ];

        return $result;
    }
}
