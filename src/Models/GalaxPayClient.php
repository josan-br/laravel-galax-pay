<?php

namespace JosanBr\GalaxPay\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $entity
 * @property int $entity_id
 * @property string $galax_id
 * @property string $galax_hash
 * @property string $created_at
 * @property string $updated_at
 * @property GalaxPaySession $galaxPaySession
 */
class GalaxPayClient extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['entity', 'entity_id', 'galax_id', 'galax_hash', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function galaxPaySession()
    {
        return $this->hasOne(GalaxPaySession::class);
    }
}
