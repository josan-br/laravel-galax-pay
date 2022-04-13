<?php

namespace JosanBr\GalaxPay\Contracts;

use JosanBr\GalaxPay\Http\Config;

interface Session
{
    public function __construct(Config $config);

    public function __get($key);

    public function __set($key, $value);

    public function expired(): bool;

    public function checkSession($clientId): void;

    public function getClientCredentials(): array;

    public function getCredentials(): array;

    public function updateOrCreate($clientId, $values = []): void;

    public function remove($clientId): bool;
}
