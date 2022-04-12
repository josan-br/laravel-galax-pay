<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property string pdf
 * @property string bankLine
 */
class Boleto extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['pdf', 'bankLine'];
}
