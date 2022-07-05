<?php

namespace JosanBr\GalaxPay;

use JosanBr\GalaxPay\Http\Config;
use JosanBr\GalaxPay\Http\Request;

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
     * @var \JosanBr\GalaxPay\Http\Request
     */
    private $request;

    /**
     * Initialize Galax Pay Service
     * 
     * @return void
     */
    public function __construct()
    {
        $this->config = new Config(config('galax_pay'));

        $this->request = new Request($this->config->options());

        $this->api = new \JosanBr\GalaxPay\Http\Api($this->config, $this->request);
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
     * Generate Id
     * 
     * @return string
     */
    public function generateId()
    {
        return uniqid('pay-') . '.' . time();
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
     * Create an instance of the http options class
     * 
     * @param array $options
     * @return \JosanBr\GalaxPay\Http\Options
     */
    public function httpOptions(array $options = [])
    {
        return new \JosanBr\GalaxPay\Http\Options($options);
    }
}
