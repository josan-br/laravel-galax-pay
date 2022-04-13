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
    protected $session = ['clientId' => null, 'tokenType' => null, 'accessToken' => null, 'expiresIn' => null, 'scope' => null];

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

    public function getCredentials(): array
    {
        return [$this->config->get('galax_id'), $this->config->get('galax_hash')];
    }

    protected function clear()
    {
        $this->session = ['clientId' => null, 'tokenType' => null, 'accessToken' => null, 'expiresIn' => null, 'scope' => null];
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
