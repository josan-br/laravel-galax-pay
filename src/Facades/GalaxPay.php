<?php

namespace JosanBr\GalaxPay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for the GalaxPay
 *
 * @method static void setClientId($clientId)
 * @method static void setOptions(array $options)
 * @method static \JosanBr\GalaxPay\QueryParams queryParams()
 */
class GalaxPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'galaxPay';
    }
}
