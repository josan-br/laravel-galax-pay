<?php

namespace JosanBr\GalaxPay\Contracts;

use JosanBr\GalaxPay\Http\Config;

interface Session
{
    public function __construct(Config $config);

    public function __get($key);

    public function __set($key, $value);

    public function expired(): bool;

    public function checkSession($clientGalaxId): bool;

    public function getClientCredentials($clientGalaxId = null): array;

    public function getPartnerCredentials(): array;

    public function updateOrCreate($clientGalaxId, $values = []): void;

    public function remove($clientGalaxId): bool;
}
