<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property string id
 * @property string name
 * @property int maxInstallment
 * @property string operatorIds
 */
class Brand extends Model
{
    public const OPERATOR_BIN = 'bin';

    public const OPERATOR_GET_NET = 'getnet';

    /**
     * @var string[]
     */
    protected $fillable = ['id', 'name', 'maxInstallment', 'operatorIds'];
}
