<?php

namespace JosanBr\GalaxPay\Sessions;

use Illuminate\Support\Arr;
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

        $this->loadSessions();
    }

    /**
     * @param int|string|null $clientGalaxId galax_id from the galax_pay_clients table
     */
    public function getClientCredentials($clientGalaxId = null): array
    {
        return [$this->config->get('credentials.client.id'), $this->config->get('credentials.client.hash')];
    }

    public function getSession($clientGalaxId)
    {
        if ($this->sessions->count() == 0) return null;

        if (is_null($this->session) || $this->session['client_galax_id'] != $clientGalaxId) {
            $this->session = $this->sessions->first(function ($item) use ($clientGalaxId) {
                return $item['client_galax_id'] == $clientGalaxId;
            });
        }

        return $this->session;
    }

    public function expired($clientGalaxId): bool
    {
        $session = $this->getSession($clientGalaxId);

        if (!$session) return true;

        return is_null($session['expires_in']) || $session['expires_in'] <= time();
    }

    public function updateOrCreate($clientGalaxId, $values = []): void
    {
        $data = Arr::add($values, 'client_galax_id', $clientGalaxId);

        $sessionKey = $this->sessions->search(function ($item) use ($clientGalaxId) {
            return $item['client_galax_id'] == $clientGalaxId && !empty($item['access_token']);
        });

        if (!is_bool($sessionKey))
            $this->sessions->pull($sessionKey);
        else $this->sessions->push($data);

        file_put_contents($this->getDirectory(), $this->sessions->toJson());
    }

    public function remove($clientGalaxId): bool
    {
        $sessionKey = $this->sessions->search(function ($item) use ($clientGalaxId) {
            return $item['client_galax_id'] == $clientGalaxId;
        });

        $this->sessions->pull($sessionKey);

        file_put_contents($this->getDirectory(), $this->sessions->toJson());

        return $this->sessions->where('client_galax_id', '=', $clientGalaxId)->count() == 0;
    }

    private function getDirectory(): string
    {
        return sprintf('%s/%s', sys_get_temp_dir(), static::GALAX_PAY_SESSIONS);
    }

    private function loadSessions()
    {
        $dir = $this->getDirectory();

        if (!file_exists($dir)) touch($dir);

        if (empty(file_get_contents($dir))) {
            $this->sessions = collect([]);
        } else {
            $content = json_decode(file_get_contents($this->getDirectory()), true);

            $this->sessions = collect($content)->sortBy('client_galax_id')->reject(function ($session) {
                return empty($session['access_token']);
            });
        }
    }
}
