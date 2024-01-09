<?php

namespace parazeet\PayMaster\Models;

class Invoice
{
    /**
     * @param string|null $paymentId Идентификатор платежа
     * @param string|null $url Адрес страницы оплаты, на которую нужно направить пользователя
     */
    public function __construct(
        public ?string $paymentId,
        public ?string $url,
    ) {}
}