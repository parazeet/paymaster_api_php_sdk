<?php

namespace parazeet\PayMaster;

use GuzzleHttp\Client;
use parazeet\PayMaster\Requests\Request;
use parazeet\PayMaster\Responses\Response;
use parazeet\PayMaster\Config\ConfigContract;
use parazeet\PayMaster\Validator\ValidatorContract;

class PayMasterJsonApi
{
    private $validator;
    private $guzzleClient;
    private $config;
    private $requestOptions;

    public const METHOD_GET = 'get';
    public const METHOD_PUT = 'put';
    public const METHOD_POST = 'post';

    protected const AVAILABLE_URI = [
        'invoices',
        'payments',
        'refunds',
        'tokenization',
        'paymenttokens',
        'receipts',
        'stickers',
    ];

    public function __construct(ConfigContract $config, ValidatorContract $validator)
    {
        $this->config = $config;
        $this->validator = $validator;

        $this->guzzleClient = new Client([
            'verify' => false,
            'http_errors' => false
        ]);

        $this->requestOptions = [
            'connect_timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ] + $this->config->keyHeader()
        ];
    }

    private function send(Request $objRequest, $method, $url): array
    {
        $body = $method == self::METHOD_GET ? [] : ['body' => \json_encode($objRequest->toArray())];

        $response = $this->guzzleClient->request(
            $method,
            $url,
            $this->requestOptions + $body
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true) ?? [];

        $this->validator->validate($jsonResponse);

        return $jsonResponse;
    }

    public function postInvoise(Request $objRequest)
    {
        return $this->send($objRequest, self::METHOD_POST, $this->config->url($objRequest->getUri()));
    }

    public function getPaymentId(Request $objRequest, int $id): Response
    {
        $url = $this->config->url($objRequest->getUri()) . $id;
        $response = $this->send($objRequest, self::METHOD_GET, $url);

        return $objRequest->createResponse($response);
    }

    public function getPayments(Request $objRequest, array $queryParameters): Response
    {
        $url = $this->config->url($objRequest->getUri());

        if (!empty($queryParameters) && is_array($queryParameters)) {
            $questionMark = '?';
            $queryString = http_build_query($queryParameters);
            $url = $url . $questionMark . $queryString;
        }

        $response = $this->send($objRequest, self::METHOD_GET, $url);

        return $objRequest->createResponse($response['items']);
    }

    public function putPayment(Request $objRequest, $id, $type /*complete,confirm,cancel*/)
    {
        $url = $this->config->url($objRequest->getUri()) . $id . '/' . $type;

        return $this->send($objRequest, self::METHOD_PUT, $url);
    }

    public function postPayment(Request $objRequest): Response
    {
        $response = $this->send($objRequest, self::METHOD_POST, $this->config->url($objRequest->getUri()));
        return $objRequest->createResponse($response);
    }
}
