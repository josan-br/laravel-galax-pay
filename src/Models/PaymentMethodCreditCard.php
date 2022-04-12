<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property Link $Link
 * @property Card $Card
 * @property int $qtdInstallments
 */
class PaymentMethodCreditCard extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['Link', 'Card', 'qtdInstallments'];

    /**
     * @var string[]
     */
    protected $modelRefs = [
        'Link' => Link::class,
        'Card' => Card::class,
    ];
}
