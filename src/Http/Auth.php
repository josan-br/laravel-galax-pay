<?php

namespace JosanBr\GalaxPay\Http;

use JosanBr\GalaxPay\Http\Config;

final class Auth
{
    /**
     * Galax Pay authentication as a partner?
     * 
     * @var bool
     */
    private $authAsPartner;

    /**
     * Config current instance
     * 
     * @var \JosanBr\GalaxPay\Http\Config
     */
    private $config;

    /**
     * Request
     * 
     * @var \JosanBr\GalaxPay\Http\Request
     */
    private $request;

    /**
     * Session manager
     * 
     * @var \JosanBr\GalaxPay\Abstracts\Session
     */
    private $sessionManager;

    /**
     * @param \JosanBr\GalaxPay\Http\Config $config
     */
    public function __construct(Config $config, Request $request)
    {
        $this->config = $config;

        $this->request = $request;

        $this->authAsPartner = $this->config->get('auth_as_partner', false);

        if ($this->config->get('session_driver') == 'database') {
            $this->sessionManager = new \JosanBr\GalaxPay\Sessions\Database($this->config);
        } else {
            $this->sessionManager = new \JosanBr\GalaxPay\Sessions\File($this->config);
        }
    }

    /**
     * Get authorization token
     * 
     * @return string
     */
    public function getAuthorizationToken($clientGalaxId)
    {
        $session = $this->sessionManager->getSession($clientGalaxId);
        return sprintf("%s %s", data_get($session, 'token_type'), data_get($session, 'access_token'));
    }

    /**
     * Check if the session has expired
     * 
     * @return bool
     */
    public function sessionExpired($clientGalaxId): bool
    {
        return $this->sessionManager->expired($clientGalaxId);
    }

    /**
     * Authenticate to the Galax Pay
     * 
     * @return void
     * @throws \JosanBr\GalaxPay\Exceptions\AuthorizationException
     * @throws \JosanBr\GalaxPay\Exceptions\GalaxPayRequestException
     */
    public function authenticate($clientGalaxId): void
    {
        $endpoint = $this->config->endpoint('authenticate');

        $options = [
            'auth' => $this->sessionManager->getClientCredentials($clientGalaxId),
            'json' => ['grant_type' => 'authorization_code', 'scope' => $this->config->get('scopes')]
        ];

        if ($this->authAsPartner) $options['headers'] = [
            'AuthorizationPartner' => ' ' . base64_encode(join(':', $this->sessionManager->getPartnerCredentials()))
        ];

        $response = $this->request->send($endpoint['method'], $endpoint['route'], $options);

        $this->sessionManager->updateOrCreate($clientGalaxId, [
            'scope' => $response['scope'],
            'token_type' => $response['token_type'],
            'access_token' => $response['access_token'],
            'expires_in' => $response['expires_in'] + time()
        ]);
    }
}
