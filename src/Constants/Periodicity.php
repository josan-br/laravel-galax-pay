<?php

namespace JosanBr\GalaxPay\Constants;

enum Periodicity: string
{
    /**
     * Weekly
     */
    case WEEKLY = 'weekly';

    /**
     * Biweekly
     */
    case BIWEEKLY = 'biweekly';

    /**
     * Monthly
     */
    case MONTHLY = 'monthly';

    /**
     * Bimonthly
     */
    case BIMONTHLY = 'bimonthly';

    /**
     * Quarterly
     */
    case QUARTERLY = 'quarterly';

    /**
     * Biannual
     */
    case BIANNUAL = 'biannual';

    /**
     * Yearly
     */
    case YEARLY = 'yearly';
}
