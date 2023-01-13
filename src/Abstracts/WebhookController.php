<?php

namespace JosanBr\GalaxPay\Abstracts;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

abstract class WebhookController extends Controller
{
    /**
     * It will be sent when a transaction has its payment status changed
     */
    private const TRANSACTION_UPDATE_STATUS = 'transaction.updateStatus';

    /**
     * It will be sent when a transaction is added to a subscription
     */
    private const SUBSCRIPTION_ADD_TRANSACTION = 'subscription.addTransaction';

    /**
     * Validate request data
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateRequest(Request $request)
    {
        $request->validate(['event' => 'required']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     */
    public function store(Request $request)
    {
        $this->validateRequest($request);

        try {
            switch ($request->event) {
                case static::TRANSACTION_UPDATE_STATUS:
                    $this->transactionUpdateStatus($request);
                    break;
                case static::SUBSCRIPTION_ADD_TRANSACTION:
                    $this->subscriptionAddTransaction($request);
                    break;

                default:
                    return response()->json(['message' => 'Event not found'], 404);
            }

            return response()->json(['message' => 'Ok']);
        } catch (\Throwable $th) {
            event(new \JosanBr\GalaxPay\Events\WebhookFailed($request, $th));
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    /**
     * A transaction has changed its payment status
     *
     * @param \Illuminate\Http\Request  $request
     * @return void
     */
    abstract protected function transactionUpdateStatus(Request $request);

    /**
     * A transaction has been added to a subscription
     *
     * @param \Illuminate\Http\Request  $request
     * @return void
     */
    protected function subscriptionAddTransaction(Request $request)
    {
        //
    }
}
