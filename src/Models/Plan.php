<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 * @property string $myId
 * @property string $name
 * @property string $periodicity
 * - weekly | biweekly | monthly | bimonthly | quarterly | biannual | yearly
 * @property int $quantity
 * @property string $additionalInfo
 * @property PlanPrice[] $PlanPrices
 */
class Plan extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['myId', 'name', 'periodicity', 'quantity', 'additionalInfo', 'PlanPrices'];

    /**
     * @var string[]
     */
    protected $modelRefs = ['PlanPrices' => PlanPrice::class];
}
