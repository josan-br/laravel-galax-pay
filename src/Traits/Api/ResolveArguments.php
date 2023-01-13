<?php

namespace JosanBr\GalaxPay\Traits\Api;

use JosanBr\GalaxPay\Http\Options;
use JosanBr\GalaxPay\QueryParams;

/**
 * Resolve the parameters passed to the API's methods
 */
trait ResolveArguments
{
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

    private function checkHttpOptions($value)
    {
        return $value instanceof Options ? $value
            : (is_array($value) ? new Options($value) : null);
    }

    /**
     * Resolve the endpoint and arguments for the request
     * 
     * @param string[] $endpoint
     * @param array $arguments
     * @return string
     */
    private function resolve(array $endpoint, array $arguments, &$clientGalaxId)
    {
        $typeId = null;
        $options = null;
        $route = $endpoint['route'];
        $routeParameters = $this->extractParameters($route);

        $hasParameters = count($routeParameters) > 0;

        switch ($endpoint['method']) {
            case \Illuminate\Http\Request::METHOD_GET:
                if ($arguments[0] instanceof QueryParams)
                    $this->options['query'] = $arguments[0]->all();
                elseif (is_array($arguments[0]))
                    $this->options['query'] = (new QueryParams($arguments[0]))->all();
                else
                    $this->options['query'] = (new QueryParams())->all();
                break;
            case \Illuminate\Http\Request::METHOD_POST:
                $optionsIndex = $hasParameters ? 2 : 1;

                $this->options['json'] = $arguments[$hasParameters ? 1 : 0];

                if (isset($arguments[$optionsIndex]))
                    $options = $this->checkHttpOptions($arguments[$optionsIndex]);
                break;
            case \Illuminate\Http\Request::METHOD_PUT:
                $this->options['json'] = $arguments[1];

                if (isset($arguments[2]))
                    $options = $this->checkHttpOptions($arguments[2]);
                break;
            case \Illuminate\Http\Request::METHOD_DELETE:
                if (isset($arguments[1]))
                    $options = $this->checkHttpOptions($arguments[1]);
                break;

            default:
                throw new \Exception("HTTP Method not supported", 1);
        }

        if (!is_null($options)) {
            $typeId = $options->id_type;
            $clientGalaxId = $options->client_galax_id;
            $this->setOptions($options->toArray());
        }

        $typeId = $typeId ?: $this->config->get('default_id_type');

        foreach ($routeParameters as $param)
            $route = str_replace(":{$param}", $param == 'typeId' ? $typeId : $arguments[0], $route);

        return $route;
    }
}
