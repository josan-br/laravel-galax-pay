<?php

namespace JosanBr\GalaxPay\Sessions;

use JosanBr\GalaxPay\Abstracts\Session;
use JosanBr\GalaxPay\Contracts\Session as ContractsSession;
use JosanBr\GalaxPay\Http\Config;

class Database extends Session implements ContractsSession
{
    /**
     * @var array
     */
    private $clientsTable;

    /**
     * @var array
     */
    private $sessionsTable;

    /**
     * @param \JosanBr\GalaxPay\Http\Config $config
     */
    public function __construct(Config $config)
    {
        parent::__construct($config);

        $this->loadTables();

        $this->loadSessions();
    }

    public function getClientCredentials($clientGalaxId = null): array
    {
        if (is_null($clientGalaxId)) throw new \Exception('The clientGalaxId can not be null.', 1);

        $client = $this->getClient($clientGalaxId);

        return [$client[$this->clientsTable['galax_id']], $client[$this->clientsTable['galax_hash']]];
    }

    public function getSession($clientGalaxId)
    {
        if ($this->sessions->count() == 0) return null;

        if (is_null($this->session) || $this->session['galaxPayClient']['galax_id'] != $clientGalaxId) {
            $this->session = $this->sessions->first(function ($item) use ($clientGalaxId) {
                return $item['galaxPayClient']['galax_id'] == $clientGalaxId;
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
        $Session = $this->sessionsTable['model'];

        $client = $this->getClient($clientGalaxId);

        /** @var \JosanBr\GalaxPay\Models\GalaxPaySession */
        $session = $Session::updateOrCreate([
            $this->sessionsTable['client_id'] => $client->id
        ], [
            $this->sessionsTable['client_id'] => $client->id,
            $this->sessionsTable['scope'] => $values['scope'],
            $this->sessionsTable['expires_in'] => $values['expires_in'],
            $this->sessionsTable['token_type'] => $values['token_type'],
            $this->sessionsTable['access_token'] => $values['access_token']
        ]);

        $session->load('galaxPayClient');

        if ($session->wasRecentlyCreated) {
            $this->sessions->push($session);
        } else {
            $this->sessions = $this->sessions->map(function ($item) use ($session) {
                $itemGalaxId = $item['galaxPayClient']['galaxId'];
                $sessionGalaxId = $session['galaxPayClient']['galaxId'];
                return $itemGalaxId == $sessionGalaxId ? $session : $item;
            });
        }
    }

    public function remove($clientGalaxId): bool
    {
        $Session = $this->sessionsTable['model'];

        $session = $Session::whereHas('galaxPayClient', function ($query) use ($clientGalaxId) {
            return $query->where('galax_id', $clientGalaxId);
        })->firstOrFail();

        if ($session->delete()) {
            $sessionKey = $this->sessions->search(function ($session) use ($clientGalaxId) {
                return $session['galaxPayClient']['galax_id'] ==  $clientGalaxId;
            });

            $this->sessions->pull($sessionKey);
        }

        return $this->sessions->where('galaxPayClient.galax_id', '=', $clientGalaxId)->count() == 0;
    }

    /** 
     * @return \JosanBr\GalaxPay\Models\GalaxPayClient 
     */
    private function getClient($clientGalaxId)
    {
        $Client = $this->clientsTable['model'];
        return $Client::where('galax_id', $clientGalaxId)->firstOrFail();
    }

    private function loadSessions()
    {
        $Session = $this->sessionsTable['model'];
        $this->sessions = $Session::with('galaxPayClient')->get();
    }

    private function loadTables()
    {
        $clientsTable = $this->config->get('galax_pay_clients');
        $sessionsTable = $this->config->get('galax_pay_sessions');

        if (!class_exists($clientsTable['model']))
            throw new \Exception("Galax pay client model not found", 1);

        if (!class_exists($sessionsTable['model']))
            throw new \Exception("Galax pay session model not found", 1);

        $this->clientsTable = $clientsTable;
        $this->sessionsTable = $sessionsTable;
    }
}
