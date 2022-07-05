<?php

namespace JosanBr\GalaxPay\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $model_type
 * @property string $model_id
 * @property string $galax_id
 * @property string $galax_hash
 * @property string $webhook_hash
 * @property string $created_at
 * @property string $updated_at
 * @property GalaxPayRegistration[] $galaxPayRegistrations
 * @property GalaxPaySession $galaxPaySession
 */
class GalaxPayClient extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['model_type', 'model_id', 'galax_id', 'galax_hash', 'webhook_hash', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galaxPayRegistrations()
    {
        return $this->hasMany(GalaxPayRegistration::class, 'galax_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function galaxPaySession()
    {
        return $this->hasOne(GalaxPaySession::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }
}
