<?php

namespace JosanBr\GalaxPay\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $galax_id
 * @property string $galax_hash
 * @property string $created_at
 * @property string $updated_at
 * @property GalaxPaySession[] $galaxPaySessions
 */
class GalaxPayClient extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['galax_id', 'galax_hash', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galaxPaySessions()
    {
        return $this->hasMany(GalaxPaySession::class);
    }
}
