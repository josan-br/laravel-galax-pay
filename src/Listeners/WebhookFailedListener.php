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
            'driver' => 'single',
            'path' => storage_path('logs/galax-pay/webhooks.log'),
        ])->warning($event->th->getMessage(), [
            'request' => $event->request,
            'file' => $event->th->getFile() . ':' . $event->th->getLine(),
        ]);
    }
}
