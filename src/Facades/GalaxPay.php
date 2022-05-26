<?php

namespace JosanBr\GalaxPay\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade for the GalaxPay
 *
 * @method static string generateId()
 * @method static \JosanBr\GalaxPay\QueryParams queryParams(array $params = [])
 * @method static \JosanBr\GalaxPay\Models\GalaxPayRegistration register(array $data)
 * 
 * @method static mixed authenticate()
 * @method static mixed listCustomers()
 * @method static mixed createCustomer()
 * @method static mixed editCustomer()
 * @method static mixed deleteCustomer()
 * @method static mixed listPlans()
 * @method static mixed createPlan()
 * @method static mixed editPlan()
 * @method static mixed deletePlan()
 * @method static mixed listCards()
 * @method static mixed createCard()
 * @method static mixed listCharges()
 * @method static mixed createCharge()
 * @method static mixed editCharge()
 * @method static mixed retryCharge()
 * @method static mixed reverseCharge()
 * @method static mixed cancelCharge()
 * @method static mixed listSubscriptions()
 * @method static mixed createSubscription()
 * @method static mixed createManualSubscription()
 * @method static mixed addTransactionSubscription()
 * @method static mixed editSubscription()
 * @method static mixed retryTransaction()
 * @method static mixed reverseTransaction()
 * @method static mixed cancelSubscription()
 * @method static mixed listTransactions()
 * @method static mixed editTransaction()
 * @method static mixed cancelTransaction()
 * @method static mixed getBoletoPDF()
 * @method static mixed editWebhooks()
 * 
 */
class GalaxPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'galaxPay';
    }
}
