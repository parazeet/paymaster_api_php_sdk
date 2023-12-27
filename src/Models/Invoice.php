<?php

namespace parazeet\PayMaster\Models;

class Invoice
{
    public function __construct(
        public ?string $paymentId,  //string	Идентификатор платежа
        public ?string $url,    //string	Адрес страницы оплаты, на которую нужно направить пользователя
    ) {}
}