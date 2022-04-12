<?php

namespace JosanBr\GalaxPay\Http;

use GuzzleHttp\Client;
use JosanBr\GalaxPay\Exceptions\AuthorizationException;
use JosanBr\GalaxPay\Exceptions\GalaxPayRequestException;

final class Request
{
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

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
            'headers' => ['Content-Type' => 'application/json']
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

            $response = $this->client->request($method, $route, $options);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $status = $e->getResponse()->getStatusCode();
            $data = json_decode($e->getResponse()->getBody()->getContents(), true);

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
}
