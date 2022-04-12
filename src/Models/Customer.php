<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 * Class Customer
 *
 * @property string $myId
 * @property string $name
 * @property string $document
 * @property string[] $emails
 * @property int[] $phones
 * @property string $password
 * @property Address $Address
 */
class Customer extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['myId', 'name', 'document', 'emails', 'phones', 'password', 'Address'];

    /**
     * @var string[]
     */
    protected $modelRefs = ['Address' => Address::class];
}
