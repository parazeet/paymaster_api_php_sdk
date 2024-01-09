<?php

namespace parazeet\PayMaster\Validator;

use parazeet\PayMaster\Exceptions\ErrorContentFormatException;
use parazeet\PayMaster\Exceptions\ErrorSystemException;
use parazeet\PayMaster\Exceptions\ErrorUnauthorizedException;
use parazeet\PayMaster\Exceptions\EmptyResponseException;

class ResponseValidator implements ValidatorContract
{
    private array $statuses = [
        // Статусы обработки сообщения
        //Код ошибки
        'validation_error' => [
            'message' => 'Некорректный запрос (неверный формат)',
            'class' => ErrorContentFormatException::class
        ],
        'not_authorized' => [
            'message' => 'Недостаточно прав для выполнения операции',
            'class' => ErrorUnauthorizedException::class
        ],
        'idempotency_key_violation' => [
            'message' => 'Нарушение уникальности ключа (дублирование запроса)',
            'class' => ErrorUnauthorizedException::class
        ],
        'invalid_operation' => [
            'message' => 'Запрос отклонен',
            'class' => ErrorContentFormatException::class
        ],
        'payment_token_revoked' => [
            'message' => 'Платежный токен отозван',
            'class' => ErrorUnauthorizedException::class
        ],
        'payment_token_blocked' => [
            'message' => 'Платежный токен временно заблокирован',
            'class' => ErrorUnauthorizedException::class
        ],

        //Коды авторизации
        'TransactionDeclined' => [
            'message' => 'Авторизация отклонена',
            'class' => ErrorUnauthorizedException::class
        ],
        'IssuerUnavailable' => [
            'message' => 'Эмитент недоступен',
            'class' => ErrorUnauthorizedException::class
        ],
        'RejectedByFraud' => [
            'message' => 'Отклонено фрод-мониторингом',
            'class' => ErrorSystemException::class
        ],
        'InvalidAmount' => [
            'message' => 'Недопустимая сумма',
            'class' => ErrorContentFormatException::class
        ],
        'InvalidAccount' => [
            'message' => 'Неверный номер карты / карта не существует',
            'class' => ErrorContentFormatException::class
        ],
        'BlockedAccount' => [
            'message' => 'Карта заблокирована (утеряна)',
            'class' => ErrorContentFormatException::class
        ],
        'OperationNotAllowed' => [
            'message' => 'Операция недоступна',
            'class' => ErrorContentFormatException::class
        ],
        'InsufficientFunds' => [
            'message' => 'Недостаточно средств',
            'class' => ErrorContentFormatException::class
        ],
        'ExpiredAccount' => [
            'message' => 'Срок действия карты истек / неверный срок действия',
            'class' => ErrorContentFormatException::class
        ],
        'PaymentLimitExceeded' => [
            'message' => 'Превышен лимит на сумму',
            'class' => ErrorContentFormatException::class
        ],
        'PaymentCountExceeded' => [
            'message' => 'Превышено кол-во попыток',
            'class' => ErrorSystemException::class
        ],
        'CardNotEnrolled' => [
            'message' => 'Карта не подписана на 3DS',
            'class' => ErrorSystemException::class
        ],
        'ThreeDSecureFailed' => [
            'message' => '3DS аутентификация не пройдена',
            'class' => ErrorSystemException::class
        ],
        'CancelledByUser' => [
            'message' => 'Платеж отклонен пользователем',
            'class' => ErrorSystemException::class
        ],
        'PaymentExpired' => [
            'message' => 'Истек срок',
            'class' => ErrorSystemException::class
        ],
    ];

    /**
     * @throws EmptyResponseException
     */
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

            /** @var class-string $exceptionClassName */
            $exceptionClassName = $this->statuses[$response['code']]['class'];

            throw new $exceptionClassName(
                $this->statuses[$response['code']]['message'] . ': ' . $errors,
                $response['code']
            );
        }
    }
}
