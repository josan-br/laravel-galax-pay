<?php

namespace JosanBr\GalaxPay\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $model
 * @property string $model_id
 * @property string $galax_id
 * @property string $galax_hash
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
    protected $fillable = ['model', 'model_id', 'galax_id', 'galax_hash', 'created_at', 'updated_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (GalaxPayClient $galaxPayClient) {
            if (empty($galaxPayClient->model))
                $galaxPayClient->model = config('galax_pay.galax_pay_clients.ref');
        });
    }

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
}
