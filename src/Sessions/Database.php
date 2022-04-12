<?php

namespace JosanBr\GalaxPay\Sessions;

use Illuminate\Support\Facades\Log;
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

    public function checkSession($clientId): void
    {
        $session = $this->sessions
            ->where($this->sessionsTable['client_id'], $clientId)->first();

        if ($session) {
            $this->set('scope', $session[$this->sessionsTable['scope']]);
            $this->set('expiresIn', $session[$this->sessionsTable['expires_in']]);
            $this->set('tokenType', $session[$this->sessionsTable['token_type']]);
            $this->set('accessToken', $session[$this->sessionsTable['access_token']]);
        } else $this->clear();

        $this->set('clientId', $clientId);
    }

    public function expired(): bool
    {
        return is_null($this->get('expiresIn')) || $this->get('expiresIn') <= time();
    }

    public function getClientCredentials(): array
    {
        $Client = $this->clientsTable['model'];

        $client = $Client::findOrFail($this->get('clientId'));

        return [$client[$this->clientsTable['galax_id']], $client[$this->clientsTable['galax_hash']]];
    }

    public function getCredentials(): array
    {
        return [$this->config->get('galax_id'), $this->config->get('galax_hash')];
    }

    public function updateOrCreate($clientId, $values = []): void
    {
        $Session = $this->sessionsTable['model'];
        Log::info('updateOrCreate', $values);
        /** @var \JosanBr\GalaxPay\Models\GalaxPaySession */
        $session = $Session::updateOrCreate([
            $this->sessionsTable['client_id'] => $clientId
        ], [
            $this->sessionsTable['client_id'] => $clientId,
            $this->sessionsTable['scope'] => $values['scope'],
            $this->sessionsTable['expires_in'] => $values['expiresIn'],
            $this->sessionsTable['token_type'] => $values['tokenType'],
            $this->sessionsTable['access_token'] => $values['accessToken']
        ]);

        if ($session->wasRecentlyCreated) {
            $this->sessions->push($session);
        } else {
            $this->sessions = $this->sessions->map(function ($item) use ($session) {
                if ($item['clientId'] == $session['clientId']) return $session;
                return $item;
            });
        }

        $this->session = collect($values)->merge(compact('clientId'))->all();
    }

    private function setClientsTable()
    {
        $table = $this->config->get('clients_table');

        if (!class_exists($table['model']))
            throw new \Exception("Galax pay client model not found", 1);

        $this->clientsTable = $table;
    }

    private function setSessions()
    {
        $table = $this->config->get('sessions_table');

        if (!class_exists($table['model']))
            throw new \Exception("Galax pay session model not found", 1);

        $this->sessionsTable = $table;

        $Session = $this->sessionsTable['model'];

        $this->sessions = $Session::all();
    }
}
