<?php

namespace JosanBr\GalaxPay\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $galax_pay_client_id
 * @property string $token_type
 * @property string $access_token
 * @property string $expires_in
 * @property string $scope
 * @property string $created_at
 * @property string $updated_at
 * @property GalaxPayClient $galaxPayClient
 */
class GalaxPaySession extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['galax_pay_client_id', 'token_type', 'access_token', 'expires_in', 'scope', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function galaxPayClient()
    {
        return $this->belongsTo(GalaxPayClient::class);
    }
}
