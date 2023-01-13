<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 * @property string qrCode
 * @property string reference
 * @property string image
 * @property string page
 * @property string endToEnd
 */
class Pix extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['qrCode', 'reference', 'image', 'page', 'endToEnd'];
}
