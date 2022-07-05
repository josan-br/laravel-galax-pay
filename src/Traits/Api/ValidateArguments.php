<?php

namespace JosanBr\GalaxPay\Traits\Api;

/**
 * Validate the parameters passed to the API's methods
 */
trait ValidateArguments
{
    /**
     * Validate arguments
     * 
     * @param string $name
     * @param array $endpoint
     * @param array|null $args
     * 
     * @return void
     * 
     * @throws \Exception
     * @throws \ArgumentCountError
     * @throws \InvalidArgumentException
     */
    private function validateArguments(string $name, array $endpoint, array $args = null): void
    {
        $hasParameters = count($this->extractParameters($endpoint['route'])) > 0;

        switch ($endpoint['method']) {
            case \Illuminate\Http\Request::METHOD_GET:
                $this->validateGet($name, $args);
                $this->validateRequestOptions($name, $args);
                break;
            case \Illuminate\Http\Request::METHOD_POST:
                $this->validatePost($name, $args, $hasParameters);
                $this->validateRequestOptions($name, $args, $hasParameters ? 2 : 1);
                break;
            case \Illuminate\Http\Request::METHOD_PUT:
                $this->validatePut($name, $args);
                $this->validateRequestOptions($name, $args, 2);
                break;
            case \Illuminate\Http\Request::METHOD_DELETE:
                $this->validateDelete($name, $args);
                $this->validateRequestOptions($name, $args);
                break;

            default:
                throw new \Exception("HTTP Method not supported", 1);
        }
    }

    /**
     * Validate arguments for 'GET' request
     * 
     * @param string $name
     * @param array $args
     * @return void
     * 
     * @throws \InvalidArgumentException
     */
    private function validateGet($name, $args)
    {
        if (is_null($args)) return;

        $this->mustBeArrayOrInstance($name, $args[0], \JosanBr\GalaxPay\QueryParams::class);
    }

    /**
     * Validate arguments for 'POST' request
     * 
     * @param string $name
     * @param array $args
     * @param bool $hasParameters
     * @return void
     * 
     * @throws \InvalidArgumentException
     */
    private function validatePost($name, $args, $hasParameters = false)
    {
        if ($hasParameters) $this->checkIsIntOrString($name, $args[0]);
        $this->mustBeArrayOrInstance($name, $args[$hasParameters ? 1 : 0], \JosanBr\GalaxPay\Abstracts\Model::class);
    }

    /**
     * Validate arguments for 'PUT' request
     * 
     * @param string $name
     * @param array $args
     * @return void
     * 
     * @throws \ArgumentCountError
     * @throws \InvalidArgumentException
     */
    private function validatePut($name, $args)
    {
        if (is_null($args) || count($args) < 2) {
            $message = 'The %s() method expects at least 2 arguments.';
            throw new \ArgumentCountError(sprintf($message, $name));
        }

        $this->checkIsIntOrString($name, $args[0]);

        $this->mustBeArrayOrInstance($name, $args[1], \JosanBr\GalaxPay\Abstracts\Model::class, 1);
    }

    /**
     * Validate arguments for 'DELETE' request
     * 
     * @param string $name
     * @param array $args
     * @return void
     * 
     * @throws \InvalidArgumentException
     */
    private function validateDelete($name, $args)
    {
        $this->checkIsIntOrString($name, $args[0]);
    }

    /**
     * Check if $value is an integer or string
     * 
     * @param string $name
     * @param mixed $value
     * @return void
     * 
     * @throws \InvalidArgumentException
     */
    private function checkIsIntOrString($name, $value)
    {
        if (!is_int($value) && !is_string($value)) {
            $message = 'The 1º argument passed to %s() must be an integer or a string, %s give.';
            throw new \InvalidArgumentException(sprintf($message, $name, gettype($value)));
        }
    }

    /**
     * Check if the id_type option is valid
     * 
     * @param string $name
     * @param mixed $type
     * @return void
     * 
     * @throws \InvalidArgumentException
     */
    private function checkIfIdTypeOptionIsValid($name, $type)
    {
        if (!is_string($type))
            throw new \InvalidArgumentException(sprintf('The id type must be a string, %s given', gettype($type)));

        $types = [\JosanBr\GalaxPay\Abstracts\Model::MY_ID, \JosanBr\GalaxPay\Abstracts\Model::GALAX_PAY_ID];

        if (!in_array($type, $types)) {
            $message = 'The option [id_type] passed to %s(...$args, $options) can be just "%s" or "%s", %s given';
            throw new \InvalidArgumentException(sprintf($message, $name, $types[0], $types[1], $type));
        }
    }

    /**
     * Validate request options
     * 
     * @param string $name
     * @param array $args
     * @param int $reqOpsIdx
     * @return void
     * 
     * @throws \InvalidArgumentException
     */
    private function validateRequestOptions($name, $args, $reqOpsIdx = 1)
    {
        $value = isset($args[$reqOpsIdx]) ? $args[$reqOpsIdx] : null;

        if (is_null($value)) return;

        $this->mustBeArrayOrInstance($name, $value, \JosanBr\GalaxPay\Http\Options::class, $reqOpsIdx);

        if (isset($value['id_type'])) $this->checkIfIdTypeOptionIsValid($name, $value['id_type']);
    }

    /**
     * Check if $value is an array or an instance of $className
     * 
     * @param string $name
     * @param mixed $value
     * @param string $className
     * @param int $argNumber
     * @return void
     * 
     * @throws \InvalidArgumentException
     */
    private function mustBeArrayOrInstance($method, $value, $className, $argNumber = 0)
    {
        if (is_array($value) || $value instanceof $className) return;

        $message = 'The %dº argument passed to %s() must be an instance of the %s or a array, %s given';
        throw new \InvalidArgumentException(sprintf($message, $argNumber + 1, $method, $className, gettype($value)));
    }
}
