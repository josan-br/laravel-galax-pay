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
     * Weekly
     */
    public const WEEKLY = 'weekly';

    /**
     * Biweekly
     */
    public const BIWEEKLY = 'biweekly';

    /**
     * Monthly
     */
    public const MONTHLY = 'monthly';

    /**
     * Bimonthly
     */
    public const BIMONTHLY = 'bimonthly';

    /**
     * Quarterly
     */
    public const QUARTERLY = 'quarterly';

    /**
     * Biannual
     */
    public const BIANNUAL = 'biannual';

    /**
     * Yearly
     */
    public const YEARLY = 'yearly';

    /**
     * @var string[]
     */
    protected $fillable = ['myId', 'name', 'periodicity', 'quantity', 'additionalInfo', 'PlanPrices'];

    /**
     * @var string[]
     */
    protected $modelRefs = ['PlanPrices' => PlanPrice::class];
}
