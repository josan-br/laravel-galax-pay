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

        $this->setClientsTable();

        $this->setSessions();
    }

    public function checkSession($clientId): bool
    {
        $session = $this->sessions->firstWhere('galaxPayClient.galax_id', '=',  $clientId);

        if ($session) {
            $this->set('scope', $session[$this->sessionsTable['scope']]);
            $this->set('expiresIn', $session[$this->sessionsTable['expires_in']]);
            $this->set('tokenType', $session[$this->sessionsTable['token_type']]);
            $this->set('accessToken', $session[$this->sessionsTable['access_token']]);
        } else $this->clear();

        $this->set('clientId', $clientId);

        return empty($session) || is_null($session) ? false : true;
    }

    public function getClientCredentials($clientId = null): array
    {
        if (is_null($clientId)) throw new \Exception('The clientId can not be null.', 1);

        $client = $this->getClient($clientId);

        return [$client[$this->clientsTable['galax_id']], $client[$this->clientsTable['galax_hash']]];
    }

    public function updateOrCreate($clientId, $values = []): void
    {
        $Session = $this->sessionsTable['model'];

        $client = $this->getClient($clientId);

        /** @var \JosanBr\GalaxPay\Models\GalaxPaySession */
        $session = $Session::updateOrCreate([
            $this->sessionsTable['client_id'] => $client->id
        ], [
            $this->sessionsTable['client_id'] => $client->id,
            $this->sessionsTable['scope'] => $values['scope'],
            $this->sessionsTable['expires_in'] => $values['expiresIn'],
            $this->sessionsTable['token_type'] => $values['tokenType'],
            $this->sessionsTable['access_token'] => $values['accessToken']
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

        $this->session = collect($values)->merge(compact('clientId'))->all();
    }

    public function remove($clientId): bool
    {
        $Session = $this->sessionsTable['model'];

        $session = $Session::whereHas('galaxPayClient', function ($query) use ($clientId) {
            return $query->where('galax_id', $clientId);
        })->firstOrFail();

        if ($session->delete()) {
            $sessionKey = $this->sessions->search(function ($session) use ($clientId) {
                return $session['galaxPayClient']['galax_id'] ==  $clientId;
            });

            $this->sessions->pull($sessionKey);
        }

        return $this->sessions->firstWhere('galaxPayClient.galax_id', '=', $clientId)->count() == 0;
    }

    /** 
     * @return \JosanBr\GalaxPay\Models\GalaxPayClient 
     */
    private function getClient($galaxId)
    {
        $Client = $this->clientsTable['model'];
        return $Client::where('galax_id', $galaxId)->firstOrFail();
    }

    private function setClientsTable()
    {
        $table = $this->config->get('galax_pay_clients');

        if (!class_exists($table['model']))
            throw new \Exception("Galax pay client model not found", 1);

        $this->clientsTable = $table;
    }

    private function setSessions()
    {
        $table = $this->config->get('galax_pay_sessions');

        if (!class_exists($table['model']))
            throw new \Exception("Galax pay session model not found", 1);

        $this->sessionsTable = $table;

        $Session = $this->sessionsTable['model'];

        $this->sessions = $Session::with('galaxPayClient')->get();
    }
}
