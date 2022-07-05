<?php

namespace JosanBr\GalaxPay\Http;

use JosanBr\GalaxPay\Http\Auth;
use JosanBr\GalaxPay\Http\Config;
use JosanBr\GalaxPay\Exceptions\AuthorizationException;

use JosanBr\GalaxPay\Traits\Api\ResolveArguments;
use JosanBr\GalaxPay\Traits\Api\ValidateArguments;

/**
 * Galax Pay API client
 */
final class Api
{
    use ResolveArguments, ValidateArguments;

    /**
     * Auth current instance
     * 
     * @var \JosanBr\GalaxPay\Http\Auth
     */
    private $auth;

    /**
     * Config current instance
     * 
     * @var \JosanBr\GalaxPay\Http\Config
     */
    private $config;

    /**
     * Request instance
     * 
     * @var \JosanBr\GalaxPay\Http\Request
     */
    private $request;

    /**
     * Request options
     * 
     * @var string[]
     */
    private $options;

    /**
     * Initialize Galax Pay Api
     * 
     * @param \JosanBr\GalaxPay\Http\Config|null $config
     * @return void
     */
    public function __construct(Config $config, Request $request)
    {
        $this->config = $config;

        $this->request = $request;

        $this->options = $this->config->options();

        $this->auth = new Auth($this->config, $this->request);
    }

    /**
     * Set config
     * 
     * @param \JosanBr\GalaxPay\Http\Config $config
     * @return $this
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Set request options
     * 
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options = [])
    {
        $this->options = $this->config->options(array_merge($this->options, $options));

        return $this;
    }

    /**
     * Send request
     * 
     * @param string $name
     * @param array $arguments
     * @return array|void
     * @throws \Throwable
     */
    public function send(string $name, array $arguments)
    {
        $endpoint = $this->config->endpoint($name);

        $this->validateArguments($name, $endpoint, $arguments);

        $route = $this->resolve($endpoint, $arguments, $clientGalaxId);

        if (empty($clientGalaxId)) $clientGalaxId = $this->config->get('credentials.client.id');

        try {
            if ($this->auth->sessionExpired($clientGalaxId))
                $this->auth->authenticate($clientGalaxId);

            $this->setAuthorizationHeader($clientGalaxId);

            return $this->request->send($endpoint['method'], $route, $this->options);
        } catch (AuthorizationException $e) {
            $this->auth->authenticate($clientGalaxId);

            $this->setAuthorizationHeader($clientGalaxId);

            return $this->request->send($endpoint['method'], $route, $this->options);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * Set authorization token in request header
     * 
     * @return void
     */
    private function setAuthorizationHeader($clientGalaxId): void
    {
        $this->options['headers'] = array_merge($this->options['headers'], [
            'Accept'        => 'application/json',
            'Authorization' => $this->auth->getAuthorizationToken($clientGalaxId)
        ]);
    }
}
