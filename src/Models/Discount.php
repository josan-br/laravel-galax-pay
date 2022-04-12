<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property int $qtdDaysBeforePayDay
 * @property string $type
 * @property int $value
 */
class Discount extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['qtdDaysBeforePayDay', 'type', 'value'];
}
