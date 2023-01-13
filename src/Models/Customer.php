<?php

namespace JosanBr\GalaxPay\Models;

use JosanBr\GalaxPay\Abstracts\Model;

/**
 * Class Customer
 *
 * @property int|string $myId
 * @property int $galaxPayId
 * @property string $name
 * @property string $document
 * @property string[] $emails
 * @property int[] $phones
 * @property bool $invoiceHoldIss
 * @property string $municipalDocument
 * @property string $status
 * @property string $createdAt
 * @property string $updatedAt
 * @property Address $Address
 */
class Customer extends Model
{
    /**
     * Customers who have active subscriptions/ individual charges.
     */
    public const ACTIVE = 'active';
    /**
     * Customers who have at least 1 overdue transaction with denied, open or lapse of time status.
     */
    public const DELAYED = 'delayed';
    /**
     * Customers who do not have active subscriptions/individual charges.
     */
    public const INACTIVE = 'inactive';
    /**
     * Customers who do not have subscriptions/ individual charges.
     */
    public const WITHOUT_SUBSCRIPTION_OR_CHARGE = 'withoutSubscriptionOrCharge';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'myId',
        'galaxPayId',
        'name',
        'document',
        'emails',
        'phones',
        'invoiceHoldIss',
        'municipalDocument',
        'status',
        'createdAt',
        'updatedAt',
        'Address'
    ];

    /**
     * @var array<string, string>
     */
    protected $modelRefs = ['Address' => Address::class];
}
