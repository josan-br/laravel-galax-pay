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
    protected $session = ['clientGalaxId' => null, 'tokenType' => null, 'accessToken' => null, 'expiresIn' => null, 'scope' => null];

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __set($key, $value)
    {
        return $this->set($key, $value);
    }

    public function expired(): bool
    {
        return is_null($this->get('expiresIn')) || $this->get('expiresIn') <= time();
    }

    /**
     * @param int|string|null $clientGalaxId galax_id from the galax_pay_clients table
     */
    public function getClientCredentials($clientGalaxId = null): array
    {
        return [$this->config->get('credentials.client.id'), $this->config->get('credentials.client.hash')];
    }

    public function getPartnerCredentials(): array
    {
        return [$this->config->get('credentials.partner.id'), $this->config->get('credentials.partner.hash')];
    }

    protected function clear()
    {
        $this->session = ['clientGalaxId' => null, 'tokenType' => null, 'accessToken' => null, 'expiresIn' => null, 'scope' => null];
    }

    protected function get($key)
    {
        return array_key_exists($key, $this->session) ? $this->session[$key] : null;
    }

    protected function set($key, $value)
    {
        if (array_key_exists($key, $this->session)) $this->session[$key] = $value;
        else throw new \Exception("The property ${key} does not exist in the session", 1);
    }
}
