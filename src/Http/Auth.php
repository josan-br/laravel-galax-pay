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
     * Client ID in session
     * 
     * @var int|string
     */
    private $clientId;

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
     * Active session
     * 
     * @var \JosanBr\GalaxPay\Contracts\Session
     */
    private $session;

    /**
     * @param \JosanBr\GalaxPay\Http\Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;

        $this->request = new Request($this->config->options());

        $this->authAsPartner = $this->config->get('auth_as_partner', false);

        if ($this->config->get('session_driver') == 'database') {
            $this->session = new \JosanBr\GalaxPay\Sessions\Database($this->config);
        } else {
            $this->clientId = $this->config->get('galax_id');
            $this->session = new \JosanBr\GalaxPay\Sessions\File($this->config);
        }

        $this->session->checkSession($this->clientId);
    }

    /**
     * Switch client in session
     * 
     * @param int|string $clientId
     * @return $this
     */
    public function switchClientInSession($clientId)
    {
        $this->clientId = $clientId;

        $this->session->checkSession($this->clientId);

        return $this;
    }

    /**
     * Get authorization token
     * 
     * @return string
     */
    public function getAuthorizationToken()
    {
        return sprintf("%s %s", $this->session->tokenType, $this->session->accessToken);
    }

    /**
     * Check if the session has expired
     * 
     * @return bool
     */
    public function sessionExpired(): bool
    {
        return $this->session->expired();
    }

    /**
     * Authenticate to the Galax Pay
     * 
     * @return void
     * @throws \JosanBr\GalaxPay\Exceptions\AuthorizationException
     * @throws \JosanBr\GalaxPay\Exceptions\GalaxPayRequestException
     */
    public function authenticate(): void
    {
        $endpoint = $this->config->endpoint('authenticate');

        $options = ['json' => ['grant_type' => 'authorization_code', 'scope' => $this->config->get('scopes')]];

        if ($this->authAsPartner) {
            $options['auth'] = $this->session->getClientCredentials();
            $options['headers'] = ['AuthorizationPartner' => ' ' . base64_encode(join(':', $this->session->getCredentials()))];
        } else {
            $options['auth'] = $this->session->getCredentials();
        }

        $response = $this->request->send($endpoint['method'], $endpoint['route'], $options);

        $expiresIn = data_get($response, 'expires_in', $this->session->expiresIn);

        $this->session->updateOrCreate($this->clientId, [
            'expiresIn' => $expiresIn + time(),
            'scope' => data_get($response, 'scope', null),
            'accessToken' => data_get($response, 'access_token', null),
            'tokenType' => data_get($response, 'token_type', $this->session->tokenType),
        ]);
    }
}
