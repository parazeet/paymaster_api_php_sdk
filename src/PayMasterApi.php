<?php

namespace parazeet\PayMaster;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use parazeet\PayMaster\Config\ConfigContract;
use parazeet\PayMaster\Requests\Request;
use parazeet\PayMaster\Responses\Response;
use parazeet\PayMaster\Validator\ValidatorContract;

class PayMasterApi
{
    private ValidatorContract $validator;
    private Client $guzzleClient;
    private ConfigContract $config;
    private array $requestOptions;

    public const METHOD_GET = 'get';
    public const METHOD_PUT = 'put';
    public const METHOD_POST = 'post';

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

    /**
     * @throws GuzzleException
     */
    private function send(Request $objRequest, $method, $url): array
    {
        $body = ($method == self::METHOD_GET or $method == self::METHOD_PUT)
            ? []
            : ['body' => \json_encode($objRequest->toArray())];

        $response = $this->guzzleClient->request(
            $method,
            $url,
            $this->requestOptions + $body
        );

        $jsonResponse = json_decode($response->getBody()->getContents(), true) ?? [];

        $this->validator->validate($jsonResponse);

        return $jsonResponse;
    }

    /**
     * @throws GuzzleException
     */
    public function post(Request $objRequest): Response
    {
        $response = $this->send($objRequest, self::METHOD_POST, $this->config->url($objRequest->getUri()));
        return $objRequest->createResponse($response);
    }

    /**
     * @throws GuzzleException
     */
    public function getId(Request $objRequest, int|string $id): Response
    {
        $url = $this->config->url($objRequest->getUri()) . $id;
        $response = $this->send($objRequest, self::METHOD_GET, $url);

        return $objRequest->createResponse($response);
    }

    /**
     * @throws GuzzleException
     */
    public function getQuery(Request $objRequest, array $queryParameters): Response
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

    /**
     * @param mixed $type examples: complete, confirm, cancel
     * @throws GuzzleException
     */
    public function put(Request $objRequest, $id, $type): array
    {
        $url = $this->config->url($objRequest->getUri()) . $id . '/' . $type;

        return $this->send($objRequest, self::METHOD_PUT, $url);
    }
}
