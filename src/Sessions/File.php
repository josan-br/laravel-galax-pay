<?php

namespace JosanBr\GalaxPay\Sessions;

use JosanBr\GalaxPay\Abstracts\Session;
use JosanBr\GalaxPay\Contracts\Session as ContractsSession;
use JosanBr\GalaxPay\Http\Config;

class File extends Session implements ContractsSession
{
    const GALAX_PAY_SESSIONS = 'galax_pay_sessions.json';

    /**
     * @param \JosanBr\GalaxPay\Http\Config $config
     */
    public function __construct(Config $config)
    {
        parent::__construct($config);

        $this->setSessions();
    }

    public function checkSession($clientGalaxId): bool
    {
        $session = $this->sessions->where('clientGalaxId', $clientGalaxId)->first();

        if ($session) {
            foreach (array_keys($this->session) as $key)
                $this->set($key, data_get($session, $key));
        } else $this->clear();

        $this->set('clientGalaxId', $clientGalaxId);

        return empty($session) || is_null($session) ? false : true;
    }

    public function updateOrCreate($clientGalaxId, $values = []): void
    {
        $sessionKey = $this->sessions->search(function ($item) use ($clientGalaxId) {
            return $item['clientGalaxId'] == $clientGalaxId;
        });

        foreach (array_keys($this->session) as $key)
            $this->set($key, data_get($values, $key));

        $this->set('clientGalaxId', $clientGalaxId);

        if ($sessionKey) {
            $this->sessions = $this->sessions->map(function ($item, $key) use ($sessionKey) {
                if ($key == $sessionKey) return $this->session;
                return $item;
            });
        } else $this->sessions->push($this->session);

        file_put_contents($this->getDirectory(), $this->sessions->toJson());
    }

    public function remove($clientGalaxId): bool
    {
        $sessionKey = $this->sessions->search(function ($item) use ($clientGalaxId) {
            return $item['clientGalaxId'] == $clientGalaxId;
        });

        $this->sessions->pull($sessionKey);

        file_put_contents($this->getDirectory(), $this->sessions->toJson());

        return $this->sessions->firstWhere('clientGalaxId', '=', $clientGalaxId)->count() == 0;
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

        $this->sessions = $this->sessions->merge($content)->sortBy('clientGalaxId');
    }
}
