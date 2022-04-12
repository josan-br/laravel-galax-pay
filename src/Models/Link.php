<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property int $minInstallment;
 * @property int $maxInstallment;
 */
class Link extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['minInstallment', 'maxInstallment'];
}
