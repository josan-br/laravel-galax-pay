<?php

namespace JosanBr\GalaxPay\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $galax_id
 * @property string $model
 * @property string $model_id
 * @property string $my_id
 * @property string $galax_pay_id
 * @property string $created_at
 * @property string $updated_at
 */
class GalaxPayRegistration extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['galax_id', 'model', 'model_id', 'my_id', 'galax_pay_id', 'created_at', 'updated_at'];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (GalaxPayRegistration $galaxPay) {
            if (empty($galaxPay->galax_id))
                $galaxPay->galax_id = config('galax_pay.credentials.client.id');
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function galaxPayClient()
    {
        return $this->belongsTo(GalaxPayClient::class, 'galax_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function entity()
    {
        return $this->morphTo('entity', 'model', 'model_id', 'id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $model
     * @param int $modelId
     */
    public function scopeWhereModelId($query, $model, $modelId)
    {
        return $query->where([['model', $model], ['model_id', $modelId]]);
    }
}
