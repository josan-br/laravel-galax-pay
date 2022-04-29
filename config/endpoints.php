<?php

/**
 * Galax Pay API Endpoints
 * @link https://docs.galaxpay.com.br
 */
return [
    /**
     * Get access token
     * @link https://docs.galaxpay.com.br/auth/token
     */
    'authenticate' => ['method' => 'POST', 'route' => '/v2/token'],

    /**
     * List Customers
     * @link https://docs.galaxpay.com.br/customers/list
     */
    'listCustomers' => ['method' => 'GET', 'route' => '/v2/customers'],

    /**
     * Create Customer
     * @link https://docs.galaxpay.com.br/customers/create
     */
    'createCustomer' => ['method' => 'POST', 'route' => '/v2/customers'],

    /**
     * Edit customer
     * @link https://docs.galaxpay.com.br/customers/edit
     */
    'editCustomer' => ['method' => 'PUT', 'route' => '/v2/customers/:customerId/:typeId'],

    /**
     * Delete customer
     * @link https://docs.galaxpay.com.br/customers/delete
     */
    'deleteCustomer' => ['method' => 'DELETE', 'route' => '/v2/customers/:customerId/:typeId'],

    /**
     * List plan
     * @link https://docs.galaxpay.com.br/plans/list
     */
    'listPlans' => ['method' => 'GET', 'route' => '/v2/plans'],

    /**
     * Create plan
     * @link https://docs.galaxpay.com.br/plans/create
     */
    'createPlan' => ['method' => 'POST', 'route' => '/v2/plans'],

    /**
     * Edit plan
     * @link https://docs.galaxpay.com.br/plans/edit
     */
    'editPlan' => ['method' => 'PUT', 'route' => '/v2/plans/:planId/:typeId'],

    /**
     * Delete plan
     * @link https://docs.galaxpay.com.br/plans/delete
     */
    'deletePlan' => ['method' => 'DELETE', 'route' => '/v2/plans/:planId/:typeId'],

    /**
     * List Cards
     * @link https://docs.galaxpay.com.br/cards/list
     */
    'listCards' => ['method' => 'GET', 'route' => '/v2/cards'],

    /**
     * Create Card
     * @link https://docs.galaxpay.com.br/cards/create
     */
    'createCard' => ['method' => 'POST', 'route' => '/v2/cards/:customerId/:typeId'],

    /**
     * List individual charges
     * @link https://docs.galaxpay.com.br/individual-charges/list
     */
    'listCharges' => ['method' => 'GET', 'route' => '/v2/charges'],

    /**
     * Create individual charge
     * @link https://docs.galaxpay.com.br/individual-charges/create
     */
    'createCharge' => ['method' => 'POST', 'route' => '/v2/charges'],

    /**
     * Edit individual charge
     * @link https://docs.galaxpay.com.br/individual-charges/edit
     */
    'editCharge' => ['method' => 'PUT', 'route' => '/v2/charges/:chargeId/:typeId'],

    /**
     * Retry charge on card
     * @link https://docs.galaxpay.com.br/individual-charges/retry
     */
    'retryCharge' => ['method' => 'PUT', 'route' => '/v2/charges/:chargeId/:typeId/retry'],

    /**
     * Reverse charge on card
     * @link https://docs.galaxpay.com.br/individual-charges/reverse
     */
    'reverseCharge' => ['method' => 'PUT', 'route' => '/v2/charges/:chargeId/:typeId/reverse'],

    /**
     * Cancel individual charge
     * @link https://docs.galaxpay.com.br/individual-charges/cancel
     */
    'cancelCharge' => ['method' => 'DELETE', 'route' => '/v2/charges/:chargeId/:typeId'],

    /**
     * List subscriptions/contracts
     * @link https://docs.galaxpay.com.br/subscriptions/list
     */
    'listSubscriptions' => ['method' => 'GET', 'route' => '/v2/subscriptions'],

    /**
     * Create subscription/contract
     * @link https://docs.galaxpay.com.br/subscriptions/create-with-plan
     * @link https://docs.galaxpay.com.br/subscriptions/create-without-plan
     */
    'createSubscription' => ['method' => 'POST', 'route' => '/v2/subscriptions'],

    /**
     * Create manual subscription/contract
     * @link https://docs.galaxpay.com.br/subscriptions/create-manual
     */
    'createManualSubscription' => ['method' => 'POST', 'route' => '/v2/subscriptions/manual'],

    /**
     * Add a transaction to subscription
     * @link https://docs.galaxpay.com.br/subscriptions/create
     */
    'addTransactionSubscription' => ['method' => 'POST', 'route' => '/v2/transactions/:subscriptionId/:typeId/add'],

    /**
     * Edit subscription/contract
     * @link https://docs.galaxpay.com.br/subscriptions/edit
     * @link https://docs.galaxpay.com.br/subscriptions/edit-value
     */
    'editSubscription' => ['method' => 'PUT', 'route' => '/v2/subscriptions/:subscriptionId/:typeId'],

    /**
     * Retry charge on card
     * @link https://docs.galaxpay.com.br/subscriptions/retry
     */
    'retryTransaction' => ['method' => 'PUT', 'route' => '/v2/transactions/:transactionId/:typeId/retry'],

    /**
     * Reverse charge on card
     * @link https://docs.galaxpay.com.br/subscriptions/reverse
     */
    'reverseTransaction' => ['method' => 'PUT', 'route' => '/v2/transactions/:transactionId/:typeId/reverse'],

    /**
     * Cancel subscription/contract
     * @link https://docs.galaxpay.com.br/subscriptions/cancel
     */
    'cancelSubscription' => ['method' => 'DELETE', 'route' => '/v2/subscriptions/:subscriptionId/:typeId'],

    /**
     * List transactions
     * @link https://docs.galaxpay.com.br/transactions/list
     */
    'listTransactions' => ['method' => 'GET', 'route' => '/v2/transactions'],

    /**
     * Edit transaction
     * @link https://docs.galaxpay.com.br/transactions/edit
     */
    'editTransaction' => ['method' => 'PUT', 'route' => '/v2/transactions/:transactionId/:typeId'],

    /**
     * Cancel a transaction
     * @link https://docs.galaxpay.com.br/subscriptions/cancel-transaction
     */
    'cancelTransaction' => ['method' => 'DELETE', 'route' => '/v2/transactions/:transactionId/:typeId'],

    /**
     * Get PDF of various bills
     * @link https://docs.galaxpay.com.br/boletos/boletos
     */
    'getBoletoPDF' => ['method' => 'POST', 'route' => '/v2/boletos/:entityType'],

    /**
     * Edit Webhooks
     * @link https://docs.galaxpay.com.br/webhook
     */
    'editWebhooks' => ['method' => 'PUT', 'route' => '/v2/webhooks']
];
