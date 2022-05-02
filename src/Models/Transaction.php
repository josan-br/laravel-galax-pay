<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 * @property int $myId
 * @property int $galaxPayId
 * @property string $chargeMyId
 * @property int $chargeGalaxPayId
 * @property string $subscriptionMyId
 * @property int $subscriptionGalaxPayId
 * @property int $value
 * @property string $payday
 * @property bool $payedOutsideGalaxPay
 * @property int $installment
 * @property string $additionalInfo
 * @property string $reasonDenied
 * @property string $authorizationCode
 * @property string $tid
 * @property string $paydayDate
 * @property string $status
 * @property string $datetimeLastSendToOperator
 * @property int $fee
 * @property string $statusDescription
 * @property string $createdAt
 * @property string $updatedAt
 * @property Boleto $Boleto
 * @property Pix $Pix
 * @property Charge $Charge
 * @property Subscription $Subscription
 * @property CreditCard $CreditCard
 */
class Transaction extends Model
{
    /**
     * 	Not yet sent to Card Operator
     */
    public const NOT_SEND = 'notSend';
    /**
     * 	Authorized
     */
    public const AUTHORIZED = 'authorized';
    /**
     * 	Captured at the Card Operator
     */
    public const CAPTURED = 'captured';
    /**
     * Card Operator Denied
     */
    public const DENIED = 'denied';
    /**
     * 	Charged at the Card Operator
     */
    public const REVERSED = 'reversed';
    /**
     * Open billet
     */
    public const PENDING_BOLETO = 'pendingBoleto';
    /**
     * Cleared billet
     */
    public const PAYED_BOLETO = 'payedBoleto';
    /**
     * Boleto downloaded by expiry of term
     */
    public const NOT_COMPENSATED = 'notCompensated';
    /**
     * Open Pix
     */
    public const PENDING_PIX = 'pendingPix';
    /**
     * Payed Pix
     */
    public const PAYED_PIX = 'payedPix';
    /**
     * Pix unavailable for payment
     */
    public const UNAVAILABLE_PIX = 'unavailablePix';
    /**
     * Manually canceled
     */
    public const CANCEL = 'cancel';
    /**
     * 	Pay out of the system
     */
    public const PAY_EXTERNAL = 'payExternal';
    /**
     * Canceled when canceling the charge
     */
    public const CANCEL_BY_CONTRACT = 'cancelByContract';
    /**
     * Free
     */
    public const FREE = 'free';

    /**
     * @var string[]
     */
    protected $fillable = [
        'myId',
        'galaxPayId',
        'chargeMyId',
        'chargeGalaxPayId',
        'subscriptionMyId',
        'subscriptionGalaxPayId',
        'value',
        'payday',
        'payedOutsideGalaxPay',
        'installment',
        'additionalInfo',
        'reasonDenied',
        'authorizationCode',
        'tid',
        'paydayDate',
        'status',
        'datetimeLastSendToOperator',
        'fee',
        'statusDescription',
        'createdAt',
        'updatedAt',
        'Boleto',
        'Pix',
        'Charge',
        'Subscription',
        'CreditCard',
    ];

    /**
     * @var string[]
     */
    protected $modelRefs = [
        'Pix' => Pix::class,
        'Boleto' => Boleto::class,
        'Charge' => Charge::class,
        'CreditCard' => CreditCard::class,
        'Subscription' => Subscription::class,
    ];
}
