<?php

namespace JosanBr\GalaxPay\Tests\AsPartner;

use JosanBr\GalaxPay\Facades\GalaxPay;
use JosanBr\GalaxPay\Http\Auth;
use JosanBr\GalaxPay\Http\Config;
use JosanBr\GalaxPay\Sessions\File;

class GalaxPayTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_authenticate_as_a_partner()
    {
        $config = new Config(config('galax_pay'));

        $auth = new Auth($config);

        if ($auth->sessionExpired($config->get('credentials.client.id')))
            $auth->authenticate($config->get('credentials.client.id'));

        $filename = sys_get_temp_dir() . '/' . File::GALAX_PAY_SESSIONS;

        $this->assertFileExists($filename);

        $this->assertNotEmpty(file_get_contents($filename));
    }

    /**
     * @test
     */
    public function it_can_get_ten_customers()
    {
        $response = GalaxPay::listCustomers([
            'query' => GalaxPay::queryParams(['limit' => 10])
        ]);

        $this->assertCount(10, $response['Customers']);
    }

    /**
     * @test
     */
    public function it_can_create_subscription_with_credit_card()
    {
        $myId = GalaxPay::generateId();

        $response = GalaxPay::createSubscription([
            'data' => [
                "myId" => $myId,
                "value" => 12999,
                "quantity" => 12,
                "periodicity" => "monthly",
                "firstPayDayDate" => date('Y-m-d'),
                "additionalInfo" => "Lorem ipsum dolor sit amet.",
                "mainPaymentMethodId" => "creditcard",
                "Customer" => [
                    "myId" => "pay-626c69563f21f9.07415510",
                    "name" => "Lorem ipsum dolor sit amet.",
                    "document" => "92111146919",
                    "emails" => [
                        "teste8858email810@galaxpay.com.br",
                        "teste5789email4547@galaxpay.com.br"
                    ],
                    "phones" => [
                        3140201512,
                        31983890110
                    ],
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
                        "myId" => "pay-626c6957562285.80824392",
                        "number" => "4111 1111 1111 1111",
                        "holder" => "JOAO J J DA SILVA",
                        "expiresAt" => "2022-04",
                        "cvv" => "363"
                    ]
                ],
                "PaymentMethodBoleto" => [
                    "fine" => 100,
                    "interest" => 200,
                    "instructions" => "Lorem ipsum dolor sit amet.",
                    "deadlineDays" => 1
                ]
            ]
        ]);

        $this->assertEquals($myId, $response['Subscription']['myId']);
    }
}
