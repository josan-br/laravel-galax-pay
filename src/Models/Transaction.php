<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 * @property int $galaxPayId
 * @property int $chargeGalaxPayId
 * @property string $chargeMyId
 * @property int $value
 * @property string $payday
 * @property string $paydayDate
 * @property int $installment
 * @property string $status
 * @property string $createdAt
 * @property string $datetimeLastSendToOperator
 * @property Boleto $Boleto
 * @property CreditCard $CreditCard
 * @property Pix $Pix
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
        'galaxPayId',
        'chargeGalaxPayId',
        'chargeMyId',
        'value',
        'payday',
        'paydayDate',
        'installment',
        'status',
        'createdAt',
        'datetimeLastSendToOperator',
        'Boleto',
        'CreditCard',
        'Pix'
    ];

    /**
     * @var string[]
     */
    protected $modelRefs = [
        'Boleto' => Boleto::class,
        'CreditCard' => CreditCard::class,
        'Pix' => Pix::class
    ];
}
