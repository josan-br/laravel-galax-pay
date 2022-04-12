<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 * @property string $payment
 * @property int $value
 */
class PlanPrice extends Model
{
    /**
     * Payment with credit card
     */
    public const CREDIT_CARD = 'creditcard';

    /**
     * Payment with billet
     */
    public const BILLET = 'boleto';

    /**
     * @var string[]
     */
    protected $fillable = ['payment', 'value'];
}
