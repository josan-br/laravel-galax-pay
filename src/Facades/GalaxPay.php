<?php

namespace JosanBr\GalaxPay\Facades;

use Illuminate\Support\Facades\Facade;

use JosanBr\GalaxPay\QueryParams;
use JosanBr\GalaxPay\Abstracts\Model;
use JosanBr\GalaxPay\Http\Options;

/**
 * Facade for the GalaxPay
 *
 * @method static string generateId()
 * 
 * @method static QueryParams queryParams(array $params = [])
 * 
 * @method static Options httpOptions(array $options = [])
 * 
 * @method static \JosanBr\GalaxPay\Models\GalaxPayRegistration register(array $data)
 * 
 * @method static mixed authenticate()
 * 
 * @method static mixed listCustomers(array|QueryParams $queryParams = [], array|Options $options = [])
 * 
 * @method static mixed createCustomer(array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed editCustomer(int|string $id, array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed deleteCustomer(int|string $id, array|Options $options = [])
 * 
 * @method static mixed listPlans(array|QueryParams $queryParams = [], array|Options $options = [])
 * 
 * @method static mixed createPlan(array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed editPlan(int|string $id, array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed deletePlan(int|string $id, array|Options $options = [])
 * 
 * @method static mixed listCards(array|QueryParams $queryParams = [], array|Options $options = [])
 * 
 * @method static mixed createCard(array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed listCharges(array|QueryParams $queryParams = [], array|Options $options = [])
 * 
 * @method static mixed createCharge(array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed editCharge(int|string $id, array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed retryCharge(int|string $id, array|Options $options = [])
 * 
 * @method static mixed reverseCharge(int|string $id, array|Options $options = [])
 * 
 * @method static mixed cancelCharge(int|string $id, array|Options $options = [])
 * 
 * @method static mixed listSubscriptions(array|QueryParams $queryParams = [], array|Options $options = [])
 * 
 * @method static mixed createSubscription(array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed createManualSubscription(array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed addTransactionSubscription(int|string $id, array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed editSubscription(int|string $id, array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed retryTransaction(int|string $id, array|Options $options = [])
 * 
 * @method static mixed reverseTransaction(int|string $id, array|Options $options = [])
 * 
 * @method static mixed cancelSubscription(int|string $id, array|Options $options = [])
 * 
 * @method static mixed listTransactions(array|QueryParams $queryParams = [], array|Options $options = [])
 * 
 * @method static mixed editTransaction(int|string $id, array|Model $data = [], array|Options $options = [])
 * 
 * @method static mixed cancelTransaction(int|string $id, array|Options $options = [])
 * 
 * @method static mixed getBoletoPDF(string $entityType, array $data, array|Options $options = [])
 * 
 * @method static mixed editWebhooks(int|string $id, array $data = [], array|Options $options = [])
 * 
 * @see \JosanBr\GalaxPay\GalaxPay
 */
class GalaxPay extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'galaxPay';
    }
}
