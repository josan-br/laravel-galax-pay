<?php

namespace JosanBr\GalaxPay\Tests\Unit;

use JosanBr\GalaxPay\Models\Address;
use JosanBr\GalaxPay\Models\Customer;
use JosanBr\GalaxPay\Models\Subscription;
use JosanBr\GalaxPay\Models\Transaction;

use JosanBr\GalaxPay\Tests\TestCase;

class ModelTest extends TestCase
{
    private static $subscriptionData = [
        "myId" => "pay-63c05c25ea5f27.91372811",
        "additionalInfo" => "Lorem ipsum dolor sit amet.",
        "mainPaymentMethodId" => "creditcard",
        "Customer" => [
            "myId" => "pay-63c05c25ecd955.79767913",
            "name" => "Lorem ipsum dolor sit amet.",
            "document" => "76118812055",
            "emails" => [
                "teste3649email4433@galaxpay.com.br",
                "teste3036email3948@galaxpay.com.br"
            ],
            "phones" => [3140201512, 31983890110],
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
                "expiresAt" => "2023-01",
                "cvv" => "363",
                "number" => "4111 1111 1111 1111",
                "holder" => "JOAO J J DA SILVA",
                "myId" => "pay-63c05c260ce386.53247636"
                ]
        ],
        "Transactions" => [
            [
                "payedOutsideGalaxPay" => false,
                "value" => 12999,
                "payday" => "2023-01-12",
                "installment" => 3,
                "additionalInfo" => "Lorem ipsum dolor sit amet.",
                "myId" => "pay-63c05c2605ece4.91057995"
            ]
        ],
    ];

    /**
     * @test
     */
    public function it_can_create_a_model_instance()
    {
        $customer = new Customer();

        $customer->myId = "pay-63c059691fc304.77650561";
        $customer->name = "Lorem ipsum dolor sit amet.";
        $customer->document = "35937886089";
        $customer->emails = ["teste8304email8996@galaxpay.com.br", "teste7336email531@galaxpay.com.br"];
        $customer->phones = [3140201512, 31983890110];

        $customer->Address->zipCode = "30411330";
        $customer->Address->street = "Rua platina";
        $customer->Address->number = "1330";
        $customer->Address->complement = "2º andar";
        $customer->Address->neighborhood = "Prado";
        $customer->Address->city = "Belo Horizonte";
        $customer->Address->state = "MG";

        $this->assertInstanceOf(Customer::class, $customer);
        $this->assertInstanceOf(Address::class, $customer->Address);

        $this->assertEquals('pay-63c059691fc304.77650561', $customer->myId);
        $this->assertEquals('Rua platina', $customer->Address->street);
    }

    /** 
     * @test
     */
    public function it_can_create_a_model_instance_from_array()
    {
        $data = static::$subscriptionData;

        $subscription = new Subscription($data);

        $this->assertInstanceOf(Subscription::class, $subscription);

        $this->assertInstanceOf(Customer::class, $subscription->Customer);

        $this->assertInstanceOf(Transaction::class, $subscription->Transactions[0]);

        $this->assertEquals($data['Transactions'][0]['myId'], $subscription->Transactions[0]->myId);

        $this->assertEquals($data['Customer']['Address']['street'], $subscription->Customer->Address->street);
    }

    /** 
     * @test
     */
    public function it_can_serialize_model()
    {
        $subscription = new Subscription(static::$subscriptionData);

        $this->assertInstanceOf(Subscription::class, $subscription);

        $this->assertEqualsCanonicalizing(static::$subscriptionData, $subscription->jsonSerialize());
    }
}
