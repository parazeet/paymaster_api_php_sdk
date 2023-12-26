<?php

namespace parazeet\PayMaster\Validator;

use parazeet\PayMaster\Validator\ValidatorContract;
use parazeet\PayMaster\Exceptions\UnknownCodeException;
use parazeet\PayMaster\Exceptions\EmptyResponseException;

class ResponseValidator implements ValidatorContract
{
    private $statuses = [
        // Статусы обработки сообщения
        //Код ошибки
        'validation_error' => [
            'message' => 'Некорректный запрос (неверный формат)',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorContentFormatException'
        ],
        'not_authorized' => [
            'message' => 'Недостаточно прав для выполнения операции',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorUnauthorizedException'
        ],
        'idempotency_key_violation' => [
            'message' => 'Нарушение уникальности ключа (дублирование запроса)',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorUnauthorizedException'
        ],
        'invalid_operation' => [
            'message' => 'Запрос отклонен',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorContentFormatException'
        ],
        'payment_token_revoked' => [
            'message' => 'Платежный токен отозван',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorUnauthorizedException'
        ],
        'payment_token_blocked' => [
            'message' => 'Платежный токен временно заблокирован',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorUnauthorizedException'
        ],

        //Коды авторизации
        'TransactionDeclined' => [
            'message' => 'Авторизация отклонена',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorUnauthorizedException'
        ],
        'IssuerUnavailable' => [
            'message' => 'Эмитент недоступен',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorUnauthorizedException'
        ],
        'RejectedByFraud' => [
            'message' => 'Отклонено фрод-мониторингом',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorSystemException'
        ],
        'InvalidAmount' => [
            'message' => 'Недопустимая сумма',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorContentFormatException'
        ],
        'InvalidAccount' => [
            'message' => 'Неверный номер карты / карта не существует',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorContentFormatException'
        ],
        'BlockedAccount' => [
            'message' => 'Карта заблокирована (утеряна)',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorContentFormatException'
        ],
        'OperationNotAllowed' => [
            'message' => 'Операция недоступна',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorContentFormatException'
        ],
        'InsufficientFunds' => [
            'message' => 'Недостаточно средств',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorContentFormatException'
        ],
        'ExpiredAccount' => [
            'message' => 'Срок действия карты истек / неверный срок действия',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorContentFormatException'
        ],
        'PaymentLimitExceeded' => [
            'message' => 'Превышен лимит на сумму',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorContentFormatException'
        ],
        'PaymentCountExceeded' => [
            'message' => 'Превышено кол-во попыток',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorSystemException'
        ],
        'CardNotEnrolled' => [
            'message' => 'Карта не подписана на 3DS',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorSystemException'
        ],
        'ThreeDSecureFailed' => [
            'message' => '3DS аутентификация не пройдена',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorSystemException'
        ],
        'CancelledByUser' => [
            'message' => 'Платеж отклонен пользователем',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorSystemException'
        ],
        'PaymentExpired' => [
            'message' => 'Истек срок',
            'class' => '\parazeet\PayMaster\Exceptions\ErrorSystemException'
        ],
    ];

    public function validate(?array $response = []): void
    {
        if (empty($response)) {
            throw new EmptyResponseException('Response is empty');
        }

        if (array_key_exists('code', $response) and array_key_exists($response['code'], $this->statuses)) {
            $errors = $response['message'];

            if (array_key_exists('errors', $response)) {
                $errors = implode(" ", $response['errors']);
            }

            throw new $this->statuses[$response['code']]['class'](
                $this->statuses[$response['code']]['message'] . ': ' . $errors,
                $response['code']
            );
        }
    }
}
