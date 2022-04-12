<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property Card $Card;
 */
class CreditCard extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['Card'];

    /**
     * @var string[]
     */
    protected $modelRefs = ['Card' => Card::class];
}
