<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 * @property string $myId
 * @property string $planMyId
 * @property int $value
 * @property int $quantity
 * @property string $periodicity
 * @property date $firstPayDayDate
 * @property string $mainPaymentMethodId
 * @property string $paymentLink
 * @property string $additionalInfo
 * @property string $status
 * @property Customer $Customer
 * @property Transaction[] $Transactions
 * @property PaymentMethodCreditCard $PaymentMethodCreditCard
 * @property PaymentMethodBoleto $PaymentMethodBoleto
 * @property PaymentMethodPix $PaymentMethodPix
 */
class Subscription extends Model
{
    public const STATUS_ACTIVE = 'active';

    public const STATUS_CANCELED = 'canceled';

    public const STATUS_CLOSED = 'closed';

    public const STATUS_STOPPED = 'stopped';

    /**
     * @var string[]
     */
    protected $fillable = [
        'myId',
        'planMyId',
        'value',
        'quantity',
        'periodicity',
        'firstPayDayDate',
        'mainPaymentMethodId',
        'paymentLink',
        'additionalInfo',
        'status',
        'Customer',
        'PaymentMethodCreditCard',
        'PaymentMethodBoleto',
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
        'PaymentMethodCreditCard' => PaymentMethodCreditCard::class
    ];
}
