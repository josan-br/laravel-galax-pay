<?php

namespace JosanBr\GalaxPay;

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
        $this->config = new \JosanBr\GalaxPay\Http\Config(config('galax_pay'));

        $this->api = new \JosanBr\GalaxPay\Http\Api($this->config);
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
    public function queryParams(array $params = [])
    {
        return new \JosanBr\GalaxPay\QueryParams($params);
    }

    /**
     * Create data reference saved in GalaxPay in your DB
     * 
     * @param array $data
     * @return \JosanBr\GalaxPay\Models\GalaxPayRegistration
     */
    public function register($data)
    {
        return \JosanBr\GalaxPay\Models\GalaxPayRegistration::create($data);
    }

    /**
     * Generate Id
     * 
     * @return string
     */
    public function generateId()
    {
        return uniqid('pay-') . '.' . time();
    }
}
