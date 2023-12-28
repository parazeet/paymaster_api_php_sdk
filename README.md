# paymaster_api_php_sdk
https://paymaster.ru/docs/ru/api

[![License](https://img.shields.io/packagist/l/vinevax/steam-php-api.svg?style=flat-square)](https://packagist.org/packages/vinevax/steam-php-api)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/parazeet/paymaster_api_php_sdk.svg?style=flat-square)](https://packagist.org/packages/parazeet/paymaster_api_php_sdk)

## Installation

```bash
composer require "parazeet/paymaster_api_php_sdk"
```

## Usage

First create a new instance of `parazeet\PayMaster\PayMasterApi` with your API key.
You can get your API key from [here](https://paymaster.ru/cpl/currentusertokens).

```php
use parazeet\PayMaster\PayMasterApi;

$api = new PayMasterApi(
    new Config('YOUR_API_KEY'),
    new ResponseValidator()
);
```
Create a new object request
```php
use parazeet\PayMaster\Requests\InvoiceRequest;

$objInvoiceRequest = (new InvoiceRequest())
    ->merchantId('YOUR_SHOP_KEY')
    ->testMode(true)
    ->invoice(['description' => 'test'])
    ->amount(['value' => 11, 'currency' => 'RUB'])
    ->paymentMethod('BankCard')
    ->customer([
        'email' => 'test@test.com',
        'phone' => '79081234567',
        'ip' => '192.168.1.1',
        'account' => 'test'
    ]);
```
And use method post for send request
```php
$api->post($objInvoiceRequest);
```
### Available methods

```php
$api->post(Request $objRequest);
$api->getId(Request $objRequest, int $id);
$api->getQuery(Request $objRequest, array $queryParameters);
$api->put(Request $objRequest, $id, $type /*complete,confirm,cancel,revoke*/);
```
### Available Request classes
```php
InvoiceRequest
PaymentRequest
PaymentTokenRequest
ReceiptRequest
RefundRequest
StickerRequest
TokenizationRequest
```