<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property string pdf
 * @property string bankLine
 * @property string bankNumber
 * @property string barCode
 * @property string bankEmissor
 * @property string bankAgency
 * @property string bankAccount
 */
class Boleto extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['pdf', 'bankLine', 'bankNumber', 'barCode', 'bankEmissor', 'bankAgency', 'bankAccount'];
}
