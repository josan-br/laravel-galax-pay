<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property int $fine
 * @property int $interest
 * @property string $instructions
 * @property int $deadlineDays
 */
class PaymentMethodBoleto extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['fine', 'interest', 'instructions', 'deadlineDays'];
}
