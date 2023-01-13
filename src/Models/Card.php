<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property int|string $myId
 * @property int $galaxPayId
 * @property int|string $customerMyId
 * @property int $customerGalaxPayId
 * @property string $hash
 * @property string $number
 * @property string $holder
 * @property string $expiresAt
 * @property string $cvv
 * @property string $createdAt
 * @property string $updatedAt
 * @property Brand $Brand
 */
class Card extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['myId', 'galaxPayId', 'customerMyId', 'customerGalaxPayId', 'hash', 'number', 'holder', 'expiresAt', 'cvv', 'createdAt', 'updatedAt', 'Brand'];

    /**
     * @var string[]
     */
    protected $modelRefs = ['Brand' => Brand::class];
}
