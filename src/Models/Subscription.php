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
 */
class Subscription extends Model
{
    public const PAY_WITH_BILLET = 'boleto';

    public const PAY_WITH_CREDIT_CARD = 'creditcard';

    public const PERIOD_WEEKLY = 'weekly';

    public const PERIOD_BIWEEKLY = 'biweekly';

    public const PERIOD_MONTHLY = 'monthly';

    public const PERIOD_BIMONTHLY = 'bimonthly';

    public const PERIOD_QUARTERLY = 'quarterly';

    public const PERIOD_BIANNUAL = 'biannual';

    public const PERIOD_YEARLY = 'yearly';

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
        'Transactions',
        'PaymentMethodCreditCard',
        'PaymentMethodBoleto'
    ];

    /**
     * @var string[]
     */
    protected $modelRefs = [
        'Customer' => Customer::class,
        'Transactions' => Transaction::class,
        'PaymentMethodCreditCard' => PaymentMethodCreditCard::class,
        'PaymentMethodBoleto' => PaymentMethodBoleto::class,
    ];
}
