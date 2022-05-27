<?php

namespace JosanBr\GalaxPay\Http;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;

use JosanBr\GalaxPay\Exceptions\AuthorizationException;
use JosanBr\GalaxPay\Exceptions\GalaxPayRequestException;

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

final class Request
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    /**
     * @var \Monolog\Logger
     */
    private $logger;

    /**
     * @var array
     */
    private $options;

    /**
     * @var array $options
     */
    public function __construct(array $options = null)
    {
        $this->options = $options;

        $clientOptions = [
            'debug' => $this->options['debug'],
            'base_uri' => $this->options['baseUri'],
            'headers' => ['Content-Type' => 'application/json'],
            'handler' => $this->setLoggingHandler(),
        ];

        $this->client = new Client($clientOptions);
    }

    /**
     * @param string $method
     * @param string $route
     * @param array $options
     * @return array
     * @throws \GuzzleHttp\Exception\ServerException
     * @throws \JosanBr\GalaxPay\Exceptions\AuthorizationException
     * @throws \JosanBr\GalaxPay\Exceptions\GalaxPayRequestException
     */
    public function send(string $method, string $route, array $options = [])
    {
        try {
            if (isset($this->options['headers'])) {
                foreach ($this->options['headers'] as $key => $value) {
                    $options['headers'][$key] = $value;
                }
            }

            $res = $this->client->request($method, $route, $options);

            return json_decode($res->getBody()->getContents() ?: (string) $res->getBody(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $body = $e->getResponse()->getBody();
            $status = $e->getResponse()->getStatusCode();
            $data = json_decode($body->getContents() ?: (string) $body, true);

            $details = data_get($data, 'error.details', []);
            $message = data_get($data, 'error.message', $e->getMessage());

            if ($status == 401)
                throw new AuthorizationException($status, $message);
            else throw new GalaxPayRequestException($message, $status, $details);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $res = $e->getResponse();
            throw new AuthorizationException($res->getStatusCode(), $res->getReasonPhrase());
        } catch (\GuzzleHttp\Exception\ServerException $e) {
            throw $e;
        }
    }

    /**
     * Setup Logger
     */
    private function getLogger()
    {
        if (!$this->logger) {
            $this->logger = with(new Logger('galax-pay'))
                ->pushHandler(new RotatingFileHandler(storage_path('logs/galax-pay/pay.log')));
        }

        return $this->logger;
    }

    /**
     * Setup Middleware
     */
    private function setGuzzleMiddleware(string $messageFormat)
    {
        return Middleware::log($this->getLogger(), new MessageFormatter($messageFormat));
    }

    /**
     * Set Logging Handler Stack
     */
    private function setLoggingHandler()
    {
        $stack = HandlerStack::create();

        $messageFormat = '{ "request": { "method": "{method}", "url": "{uri}", "headers": "{req_headers}", "payload": {req_body} }, "response": { "status": {code}, "data": {res_body} } }';

        $stack->unshift($this->setGuzzleMiddleware($messageFormat));

        return $stack;
    }
}
