<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property string $myId
 * @property int $value
 * @property date $payday
 * @property string $additionalInfo
 * @property bool $payedOutsideGalaxPay
 * @property string $mainPaymentMethodId
 * @property Customer $Customer
 * @property PaymentMethodBoleto $PaymentMethodBoleto
 * @property PaymentMethodCreditCard $PaymentMethodCreditCard
 * @property Transaction[] $Transactions
 */
class Charge extends Model
{
    public const PIX = 'pix';

    public const BILLET = 'boleto';

    public const CREDIT_CARD = 'creditcard';

    /**
     * @var string[]
     */
    protected $fillable = [
        'myId',
        'value',
        'payday',
        'additionalInfo',
        'payedOutsideGalaxPay',
        'mainPaymentMethodId',
        'Customer',
        'PaymentMethodBoleto',
        'PaymentMethodCreditCard',
        'Transactions'
    ];

    /**
     * @var string[]
     */
    protected $modelRefs = [
        'Customer' => Customer::class,
        'PaymentMethodBoleto' => PaymentMethodBoleto::class,
        'PaymentMethodCreditCard' => PaymentMethodCreditCard::class,
        'Transactions' => Transaction::class
    ];

    public static function fromJson(string $json): self
    {
        return parent::fromJson($json);
    }
}
