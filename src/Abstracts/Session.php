<?php

namespace JosanBr\GalaxPay\Abstracts;

use JosanBr\GalaxPay\Http\Config;

abstract class Session
{
    public const IN_FILE = 'file';

    public const IN_DATABASE = 'database';

    /**
     * @var \JosanBr\GalaxPay\Http\Config
     */
    protected $config;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected $sessions;

    /**
     * @var array
     */
    protected $session;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getPartnerCredentials(): array
    {
        return [$this->config->get('credentials.partner.id'), $this->config->get('credentials.partner.hash')];
    }

    abstract public function getSession($clientGalaxId);

    abstract public function expired($clientGalaxId): bool;

    abstract public function getClientCredentials($clientGalaxId = null): array;

    abstract public function updateOrCreate($clientGalaxId, $values = []): void;

    abstract public function remove($clientGalaxId): bool;
}
