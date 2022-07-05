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
    protected $fillable = ['galax_id', 'model_type', 'model_id', 'my_id', 'galax_pay_id', 'created_at', 'updated_at'];

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
    public function model()
    {
        return $this->morphTo();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $model
     * @param int $modelId
     */
    public function scopeWhereModelId($query, $model, $modelId)
    {
        return $query->where([['model_type', $model], ['model_id', $modelId]]);
    }
}
