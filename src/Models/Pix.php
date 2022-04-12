<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 * @property string qrCode
 * @property string image
 * @property string page
 */
class Pix extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['qrCode', 'image', 'page',];
}
