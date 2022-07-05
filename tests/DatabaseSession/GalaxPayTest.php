<?php

namespace JosanBr\GalaxPay\Tests\DatabaseSession;

use JosanBr\GalaxPay\Constants\PaymentMethod;
use JosanBr\GalaxPay\Constants\Periodicity;
use JosanBr\GalaxPay\Facades\GalaxPay;

use JosanBr\GalaxPay\Http\Auth;
use JosanBr\GalaxPay\Http\Config;
use JosanBr\GalaxPay\Http\Request;

use JosanBr\GalaxPay\Models\GalaxPayClient;
use JosanBr\GalaxPay\Models\GalaxPaySession;

class GalaxPayTest extends TestCase
{
    /**
     * @return \JosanBr\GalaxPay\Models\GalaxPayClient
     */
    private function createGalaxPayClient()
    {
        return \JosanBr\GalaxPay\Models\GalaxPayClient::create([
            'model_id' => 1,
            'model_type' => \JosanBr\GalaxPay\Models\GalaxPayClient::class,
            'galax_id' => 5473,
            'galax_hash' => '83Mw5u8988Qj6fZqS4Z8K7LzOo1j28S706R0BeFe',
        ]);
    }

    /**
     * @test
     */
    public function it_can_create_galax_pay_client()
    {
        $client = $this->createGalaxPayClient();

        /** @var \JosanBr\GalaxPay\Models\GalaxPayClient */
        $client = GalaxPayClient::where('galax_id',  $client->galax_id)->firstOrFail();

        $this->assertNotEmpty($client);
    }

    /**
     * @test
     */
    public function it_can_create_galax_pay_session()
    {
        $client = $this->createGalaxPayClient();

        $session = GalaxPaySession::create([
            'galax_pay_client_id' => $client->id,
            'token_type' => 'Bearer',
            'access_token' => '4fsd5f7sd6fs6a4fsaf7saf4sa65f4sa6f7sa98',
            'expires_in' => 600,
            'scope' => config('galax_pay.scopes')
        ]);

        $this->assertNotEmpty($session);
    }

    /**
     * @test
     */
    public function it_can_authenticate()
    {
        $config = new Config(config('galax_pay'));
        $request = new Request($config->options());

        $auth = new Auth($config, $request);

        $client = $this->createGalaxPayClient();

        if ($auth->sessionExpired($client->galax_id))
            $auth->authenticate($client->galax_id);

        $session = GalaxPaySession::whereHas('galaxPayClient', function ($query) use ($client) {
            return $query->where('id', $client->id);
        })->first();

        $this->assertNotEmpty($session);
    }

    /**
     * @test
     * 
     */
    public function it_can_get_ten_customers()
    {
        $client = $this->createGalaxPayClient();

        $response = GalaxPay::listCustomers([
            'limit' => 10
        ], [
            'client_galax_id' => $client->galax_id
        ]);

        $this->assertCount(10, $response['Customers']);
    }

    /**
     * @test
     */
    public function it_can_create_subscription_with_credit_card()
    {
        $myId = GalaxPay::generateId();
        $customerId = GalaxPay::generateId();

        $client = $this->createGalaxPayClient();

        $options = GalaxPay::httpOptions(['client_galax_id' => $client->galax_id]);

        $response = GalaxPay::createSubscription([
            "myId" => $myId,
            "value" => 12999,
            "quantity" => 12,
            "firstPayDayDate" => date('Y-m-d'),
            "periodicity" => Periodicity::MONTHLY,
            "additionalInfo" => "Lorem ipsum dolor sit amet.",
            "mainPaymentMethodId" => PaymentMethod::CREDIT_CARD,
            "Customer" => [
                "myId" => $customerId,
                "name" => "Thiago Enrico Marcos Lopes",
                "document" => "22820654339",
                "emails" => ["thiagoenricolopes@gsw.com.br"],
                "phones" => [2738359874, 27991065923],
                "Address" => [
                    "zipCode" => "30411330",
                    "street" => "Rua platina",
                    "number" => "1330",
                    "complement" => "2º andar",
                    "neighborhood" => "Prado",
                    "city" => "Belo Horizonte",
                    "state" => "MG"
                ]
            ],
            "PaymentMethodCreditCard" => [
                "Card" => [
                    "cvv" => "363",
                    "myId" => GalaxPay::generateId(),
                    "number" => "4111 1111 1111 1111",
                    "expiresAt" => date('Y') . '-' . intval(date('m')) + 5,
                    "holder" => "JOAO J J DA SILVA",
                ]
            ],
        ], $options);

        GalaxPay::cancelSubscription($myId, $options);
        GalaxPay::deleteCustomer($customerId, $options);

        $this->assertEquals($myId, $response['Subscription']['myId']);
    }
}
