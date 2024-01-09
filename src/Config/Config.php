<?php

namespace parazeet\PayMaster\Config;

class Config implements ConfigContract
{
    public function __construct(
        private readonly string  $apiKey,
        private readonly ?string $idempotencyKey = null,
        private readonly string  $apiUrl = 'https://paymaster.ru/api/v2/'
    )
    {
    }

    public function url(string $url): string
    {
        return $this->apiUrl . $url;
    }

    public function keyHeader(): array
    {
        $idempotencyKey = !empty($this->idempotencyKey) ? ['Idempotency-Key' => $this->idempotencyKey] : [];

        return [
            'Authorization' => 'Bearer ' . $this->apiKey,
        ] + $idempotencyKey;
    }
}