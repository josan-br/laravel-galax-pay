<?php

namespace JosanBr\GalaxPay\Http;

final class Config
{
    /**
     * @var string[]
     */
    private $config;

    /**
     * @var string[][]
     */
    private $endpoints;

    /**
     * Initialize configuration
     * 
     * @param array $config
     * @param array $endpoints
     * @return void
     */
    public function __construct(array $config = [], array $endpoints = [])
    {
        $this->config = $this->merge($config, $this->getDefaultConfig());
        $this->endpoints = $this->merge($endpoints, $this->getEndpoints());
    }

    /**
     * Get Config by key
     * 
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return data_get($this->config, $key, $default);
    }

    /**
     * Get an endpoint from the endpoint list
     * 
     * @param string $name
     * @return array
     * @throws \Exception
     */
    public function endpoint(string $name): array
    {
        if (!in_array($name, array_keys($this->endpoints)))
            throw new \Exception("The endpoint $name does not exist", 1);

        return data_get($this->endpoints, $name);
    }

    /**
     * Custom request options
     * 
     * @param array $options
     * @return array
     * @link https://docs.guzzlephp.org/en/stable/request-options.html
     */
    public function options(array $options = null): array
    {
        $conf['debug'] = isset($options['debug']) ? $options['debug'] : false;

        $conf['baseUri'] = isset($options['url']) ? $options['url'] : $this->get('api_urls.' . $this->get('env'));

        if (isset($options['headers'])) {
            $conf['headers'] = $options['headers'];

            if (isset($options['headers']['timeout']))
                $conf['headers']['timeout'] = $options['headers']['timeout'];
            else
                $conf['headers']['timeout'] = $this->get('timeout', 30.0);
        } else {
            $conf['headers'] = ['timeout' => $this->get('timeout', 30.0)];
        }

        return $conf;
    }

    /**
     * Get endpoints list
     * 
     * @return string[][]
     */
    private function getEndpoints(): array
    {
        return require __DIR__ . '/../../config/endpoints.php';
    }

    /**
     * Get default configuration
     * 
     * @return array
     */
    private function getDefaultConfig(): array
    {
        return require __DIR__ . '/../../config/galax_pay.php';
    }

    /**
     * Merge arrays
     * 
     * @param array $high
     * @param array $low
     * @return array
     */
    private function merge(array $high, array $low): array
    {
        foreach ($high as $key => $value)
            if (!is_null($value)) $low[$key] = $value;

        return $low;
    }
}
