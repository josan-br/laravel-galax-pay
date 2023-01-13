<?php

namespace JosanBr\GalaxPay\Sessions;

use JosanBr\GalaxPay\Abstracts\Session;

use JosanBr\GalaxPay\Http\Config;

class Database extends Session
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
    }

    public function getClientCredentials($clientGalaxId = null): array
    {
        if (is_null($clientGalaxId)) throw new \Exception('The clientGalaxId can not be null.', 1);

        $client = $this->getClient($clientGalaxId);

        return [$client[$this->clientsTable['galax_id']], $client[$this->clientsTable['galax_hash']]];
    }

    public function getSession($clientGalaxId)
    {
        /** @var \Illuminate\Database\Eloquent\Model */
        $Session = $this->sessionsTable['ref'];

        return $Session::whereHas('galaxPayClient', function ($query) use ($clientGalaxId) {
            return $query->where('galax_id', $clientGalaxId);
        })->first();
    }

    public function expired($clientGalaxId): bool
    {
        $session = $this->getSession($clientGalaxId);

        if (!$session) return true;

        return is_null($session['expires_in']) || $session['expires_in'] <= time();
    }

    public function updateOrCreate($clientGalaxId, $values = []): void
    {
        $Session = $this->sessionsTable['ref'];

        $client = $this->getClient($clientGalaxId);

        /** @var \JosanBr\GalaxPay\Models\GalaxPaySession */
        $Session::updateOrCreate([
            $this->sessionsTable['client_id'] => $client->id
        ], [
            $this->sessionsTable['client_id'] => $client->id,
            $this->sessionsTable['scope'] => $values['scope'],
            $this->sessionsTable['expires_in'] => $values['expires_in'],
            $this->sessionsTable['token_type'] => $values['token_type'],
            $this->sessionsTable['access_token'] => $values['access_token']
        ]);
    }

    public function remove($clientGalaxId): bool
    {
        $Session = $this->sessionsTable['ref'];

        $session = $Session::whereHas('galaxPayClient', function ($query) use ($clientGalaxId) {
            return $query->where('galax_id', $clientGalaxId);
        })->first();

        return $session && $session->delete();
    }

    /** 
     * @return \JosanBr\GalaxPay\Models\GalaxPayClient 
     */
    private function getClient($clientGalaxId)
    {
        /** @var \Illuminate\Database\Eloquent\Model */
        $Client = $this->clientsTable['ref'];

        return $Client::where('galax_id', $clientGalaxId)->firstOrFail();
    }

    private function loadTables()
    {
        $clientsTable = $this->config->get('galax_pay_clients');
        $sessionsTable = $this->config->get('galax_pay_sessions');

        if (!class_exists($clientsTable['ref']))
            throw new \Exception("Galax pay client model reference not found", 1);

        if (!class_exists($sessionsTable['ref']))
            throw new \Exception("Galax pay session model reference not found", 1);

        $this->clientsTable = $clientsTable;
        $this->sessionsTable = $sessionsTable;
    }
}
