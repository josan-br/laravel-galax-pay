<?php

namespace JosanBr\GalaxPay\Http;

use JosanBr\GalaxPay\Http\Auth;
use JosanBr\GalaxPay\Http\Config;
use JosanBr\GalaxPay\Exceptions\AuthorizationException;
use JosanBr\GalaxPay\QueryParams;

/**
 * Galax Pay API client
 */
final class Api
{
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
     * @param \JosanBr\GalaxPay\Http\Auth|null $auth
     * @param \JosanBr\GalaxPay\Http\Config|null $config
     * @return void
     */
    public function __construct(Auth $auth = null, Config $config = null)
    {
        $this->auth = $auth;
        $this->config = $config;
        $this->options = $this->config->options();
        $this->request = new Request($this->options);
    }

    /**
     * Set auth
     * 
     * @param \JosanBr\GalaxPay\Http\Auth $auth
     * @return $this
     */
    public function setAuth(Auth $auth)
    {
        $this->auth = $auth;

        $this->setAuthorizationHeader();

        return $this;
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

        $this->request = new Request($this->options);

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

        $this->validateArguments($name, $endpoint['route'], $arguments);

        $route = $this->resolve($endpoint, $arguments);

        try {
            if (isset($arguments['clientId']))
                $this->auth->setClientId($arguments['clientId']);

            if ($this->auth->sessionExpired())
                $this->auth->authenticate();

            $this->setAuthorizationHeader();

            return $this->request->send($endpoint['method'], $route, $this->options);
        } catch (AuthorizationException $e) {
            $this->auth->authenticate();

            $this->setAuthorizationHeader();

            return $this->request->send($endpoint['method'], $route, $this->options);
        } catch (\Throwable $e) {
            throw $e;
        }
    }

    /**
     * Extract route parameters
     * 
     * @param string $route
     * @return string[]
     */
    private function extractParameters(string $route): array
    {
        preg_match_all('/\:(\w+)/im', $route, $parameters);
        return $parameters[1];
    }

    /**
     * Resolve the endpoint and arguments for the request
     * 
     * @param string[] $endpoint
     * @param array $arguments
     * @return string
     */
    private function resolve(array $endpoint, array $arguments): string
    {
        $route = $endpoint['route'];
        $query = data_get($arguments, '0.query');
        $params = data_get($arguments, '0.params', []);

        if ($endpoint['method'] == 'GET') {
            $query = is_null($query) ? QueryParams::build() : $query->build();
        } else $query = null;

        if ($endpoint['method'] != 'GET' && isset($arguments[0]['data']))
            $this->options['json'] = $arguments[0]['data'];

        foreach ($this->extractParameters($route) as $param) {
            if (isset($params[$param]))
                $route = str_replace(":$param", $params[$param], $route);
        }

        if (is_string($query) && strlen($query)) $route .= $query;

        return $route;
    }

    /**
     * Set authorization token in request header
     * 
     * @return void
     */
    private function setAuthorizationHeader(): void
    {
        $this->options['headers'] = array_merge($this->options['headers'], [
            'Accept'        => 'application/json',
            'Authorization' => $this->auth->getAuthorizationToken()
        ]);
    }

    /**
     * Validate arguments
     * 
     * @param string $name
     * @param string $route
     * @param array|null $args
     * 
     * @return void
     * 
     * @throws \Exception
     * @throws \TypeError
     * @throws \ArgumentCountError
     * @throws \InvalidArgumentException
     */
    private function validateArguments(string $name, string $route, array $args = null): void
    {
        if (is_null($args)) return;

        if (count($args) > 1)
            throw new \ArgumentCountError(sprintf('The %s() function accepts only one array type argument', $name));

        if (isset($args[0]) && !is_array($args[0])) {
            $message = 'The argument passed to %s() must be of type array or null, %s given';
            throw new \TypeError(sprintf($message, $name, gettype($args[0])));
        }

        if (isset($args[0]['query']) && !($args[0]['query'] instanceof QueryParams)) {
            $message = 'The argument [query] passed to %s() must be an instance of the %s, %s given';
            throw new \InvalidArgumentException(sprintf($message, $name, QueryParams::class, gettype($args[0]['query'])));
        }

        if (isset($args[0]['data']) && !is_array($args[0]['data']) && !is_object($args[0]['data'])) {
            $message = 'The argument [data] passed to %s() must be of type array, %s given';
            throw new \InvalidArgumentException(sprintf($message, $name, gettype($args[0]['data'])));
        }

        if (isset($args[0]['params'])) {
            if (!is_array($args[0]['params'])) {
                $message = 'The argument [params] passed to %s() must be of type array, %s given';
                throw new \InvalidArgumentException(sprintf($message, $name, gettype($args[0]['params'])));
            }

            foreach (array_values($this->extractParameters($route)) as $param) {
                if (!in_array($param, array_keys($args[0]['params']))) {
                    throw new \Exception(sprintf('Parameter "%s" is required in array [params]', $param));
                }
            }
        }
    }
}
