<?php

namespace JosanBr\GalaxPay\Tests\Feature\Sessions;

use JosanBr\GalaxPay\Constants\PaymentMethod;
use JosanBr\GalaxPay\Constants\Periodicity;
use JosanBr\GalaxPay\Facades\GalaxPay;

use JosanBr\GalaxPay\Http\Auth;
use JosanBr\GalaxPay\Http\Config;
use JosanBr\GalaxPay\Http\Request;

use JosanBr\GalaxPay\Sessions\File;

use JosanBr\GalaxPay\Tests\TestCase;

class FileSessionAsPartnerTest extends TestCase
{
    /**
     * @test
     * @define-env usesFileSessionAsPartner
     */
    public function it_can_authenticate_as_a_partner()
    {
        $config = new Config(config('galax_pay'));
        $request = new Request($config->options());

        $auth = new Auth($config, $request);

        if ($auth->sessionExpired($config->get('credentials.client.id')))
            $auth->authenticate($config->get('credentials.client.id'));

        $filename = sys_get_temp_dir() . '/' . File::GALAX_PAY_SESSIONS;

        $this->assertFileExists($filename);

        $this->assertNotEmpty(file_get_contents($filename));
    }

    /**
     * @test
     * @define-env usesFileSessionAsPartner
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
     * @define-env usesFileSessionAsPartner
     */
    public function it_can_create_subscription_with_credit_card()
    {
        $myId = GalaxPay::generateId();

        $customerId = GalaxPay::generateId();

        $response = GalaxPay::createSubscription([
            "myId" => $myId,
            "value" => 12999,
            "quantity" => 12,
            "firstPayDayDate" => date('Y-m-d'),
            "periodicity" => Periodicity::MONTHLY->value,
            "additionalInfo" => "Lorem ipsum dolor sit amet.",
            "mainPaymentMethodId" => PaymentMethod::CREDIT_CARD->value,
            "Customer" => [
                "myId" => $customerId,
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
                    "cvv" => "363",
                    "myId" => GalaxPay::generateId(),
                    "number" => "4111 1111 1111 1111",
                    "expiresAt" => date('Y') . '-' . intval(date('m')) + 5,
                    "holder" => "JOAO J J DA SILVA",
                ]
            ],
        ]);

        GalaxPay::cancelSubscription($myId);
        GalaxPay::deleteCustomer($customerId);

        $this->assertEquals($myId, $response['Subscription']['myId']);
    }
}
