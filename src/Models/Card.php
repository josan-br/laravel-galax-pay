<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property string $myId
 * @property string $hash
 * @property string $number
 * @property string $holder
 * @property string $expiresAt
 * @property string $cvv
 * @property Brand $Brand
 */
class Card extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['myId', 'hash', 'number', 'holder', 'expiresAt', 'cvv', 'Brand'];

    /**
     * @var string[]
     */
    protected $modelRefs = ['Brand' => Brand::class];
}
