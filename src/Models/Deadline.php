<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property string $type
 * @property int $value
 */
class Deadline extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['type', 'value'];
}
