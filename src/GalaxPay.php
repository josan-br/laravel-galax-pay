<?php

namespace JosanBr\GalaxPay;

use JosanBr\GalaxPay\Http\Api;
use JosanBr\GalaxPay\Http\Auth;
use JosanBr\GalaxPay\Http\Config;
use JosanBr\GalaxPay\QueryParams;

/**
 * Galax Pay Service
 */
class GalaxPay
{
    /**
     * Galax Pay Api instance
     * 
     * @var \JosanBr\GalaxPay\Http\Api
     */
    private $api;

    /**
     * Auth instance
     * 
     * @var \JosanBr\GalaxPay\Http\Auth
     */
    private $auth;

    /**
     * Config instance
     * 
     * @var \JosanBr\GalaxPay\Http\Config
     */
    private $config;

    /**
     * Initialize Galax Pay Service
     * 
     * @return void
     */
    public function __construct()
    {
        $this->config = new Config(config('galax_pay'));

        $this->auth = new Auth($this->config);

        $this->api = new Api($this->auth, $this->config);
    }

    /**
     * Call a Galax Pay endpoint
     * 
     * @param string $name
     * @param array $arguments
     * @return array
     */
    public function __call($name, $arguments)
    {
        return $this->api->send($name, $arguments);
    }

    /**
     * Get config
     * 
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function getConfig(string $key, $default = null)
    {
        return $this->config->get($key, $default);
    }

    /**
     * Switch client in session
     * 
     * @param int|string $clientId
     * @return void
     */
    public function switchClientInSession($clientId)
    {
        $this->auth = $this->auth->switchClientInSession($clientId);

        $this->api->setAuth($this->auth);
    }

    /**
     * Add more information to the request
     * 
     * @param array $options
     * @return void
     * @link https://docs.guzzlephp.org/en/stable/request-options.html
     */
    public function setApiOptions(array $options)
    {
        $this->api->setOptions($options);
    }

    /**
     * Create URL Query Params
     * 
     * @param string[] $params
     * @return \JosanBr\GalaxPay\QueryParams
     */
    public static function queryParams(array $params = [])
    {
        return new QueryParams($params);
    }
}
