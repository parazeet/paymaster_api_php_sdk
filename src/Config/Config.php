<?php

namespace parazeet\PayMaster\Config;

use parazeet\PayMaster\Config\ConfigContract;

class Config implements ConfigContract
{
    private $apiKey;
    private $apiUrl;
    private $idempotencyKey;

    public function __construct(
        string $apiKey,
        string $aipUrl = 'https://paymaster.ru/api/v2/'
    ) {
        $this->apiKey = $apiKey;
        $this->apiUrl = $aipUrl;
    }

    public function url(string $url): string
    {
        return $this->apiUrl . $url;
    }

    public function keyHeader(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiKey
        ];
    }
}