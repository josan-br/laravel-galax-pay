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
 * @property PaymentMethodPix $PaymentMethodPix
 * @property Transaction[] $Transactions
 */
class Charge extends Model
{
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
        'PaymentMethodPix',
        'Transactions'
    ];

    /**
     * @var string[]
     */
    protected $modelRefs = [
        'Customer'                => Customer::class,
        'Transactions'            => Transaction::class,
        'PaymentMethodPix'        => PaymentMethodPix::class,
        'PaymentMethodBoleto'     => PaymentMethodBoleto::class,
        'PaymentMethodCreditCard' => PaymentMethodCreditCard::class,
    ];
}
