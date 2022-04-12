<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 *
 * @property string $zipCode
 * @property string $street
 * @property string $number
 * @property string $complement
 * @property string $neighborhood
 * @property string $city
 * @property string $state
 */
class Address extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['zipCode', 'street', 'number', 'complement', 'neighborhood', 'city', 'state'];
}
