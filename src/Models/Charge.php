<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property int|string $myId
 * @property int $galaxPayId
 * @property int $value
 * @property string $status
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
     * Active
     */
    public const ACTIVE = 'active';
    /** 
     * Cancelled
     */
    public const CANCELED = 'canceled';
    /** 
     * Closed
     */
    public const CLOSED = 'closed';

    /**
     * @var string[]
     */
    protected $fillable = [
        'myId',
        'galaxPayId',
        'value',
        'status',
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
