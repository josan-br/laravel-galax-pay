<?php

namespace JosanBr\GalaxPay\Sessions;

use JosanBr\GalaxPay\Abstracts\Session;
use JosanBr\GalaxPay\Contracts\Session as ContractsSession;
use JosanBr\GalaxPay\Http\Config;

class File extends Session implements ContractsSession
{
    private const GALAX_PAY_SESSIONS = 'galax_pay_sessions.json';

    /**
     * @param \JosanBr\GalaxPay\Http\Config $config
     */
    public function __construct(Config $config)
    {
        parent::__construct($config);

        $this->setSessions();
    }

    public function checkSession($clientId): void
    {
        $session = $this->sessions->where('client_id', $clientId)->first();

        if ($session) {
            foreach (array_keys($this->session) as $key)
                $this->set($key, data_get($session, $key));
        } else $this->clear();

        $this->set('client_id', $clientId);
    }

    public function expired(): bool
    {
        return is_null($this->get('expiresIn')) || $this->get('expiresIn') <= time();
    }

    public function getClientCredentials(): array
    {
        return [$this->config->get('galax_id'), $this->config->get('galax_hash')];
    }

    public function getCredentials(): array
    {
        return [$this->config->get('galax_id'), $this->config->get('galax_hash')];
    }

    public function updateOrCreate($clientId, $values = []): void
    {
        $sessionKey = $this->sessions->search(function ($item) use ($clientId) {
            return $item['clientId'] == $clientId;
        });

        if ($sessionKey) {
            foreach (array_keys($this->session) as $key)
                $this->set($key, data_get($values, $key));

            $this->set('clientId', $clientId);

            $this->sessions = $this->sessions->map(function ($item, $key) use ($sessionKey) {
                if ($key == $sessionKey) return $this->session;
                return $item;
            });
        } else $this->sessions->push($this->session);

        file_put_contents($this->getDirectory(), $this->sessions->toJson());
    }

    private function getDirectory(): string
    {
        return sprintf('%s/%s', sys_get_temp_dir(), static::GALAX_PAY_SESSIONS);
    }

    private function setSessions()
    {
        $this->sessions = collect([]);

        if (!file_exists($this->getDirectory())) return;

        if (!empty(file_get_contents($this->getDirectory()))) return;

        $content = json_decode(file_get_contents($this->getDirectory()), true);

        $this->sessions = $this->sessions->merge($content)->sortBy('clientId');
    }
}