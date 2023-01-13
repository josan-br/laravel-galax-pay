<?php

namespace JosanBr\GalaxPay\Listeners;

use JosanBr\GalaxPay\Events\WebhookFailed;

class WebhookFailedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \JosanBr\GalaxPay\Events\WebhookFailed  $event
     * @return void
     */
    public function handle(WebhookFailed $event)
    {
        \Illuminate\Support\Facades\Log::build([
            'driver' => 'daily',
            'path' => storage_path('logs/galax-pay/webhooks.log'),
        ])->error($event->th, $event->request->toArray());
    }
}
