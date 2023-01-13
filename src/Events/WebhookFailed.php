<?php

namespace JosanBr\GalaxPay\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class WebhookFailed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var \Illuminate\Http\Request $request
     */
    public $request;

    /**
     * @var \Throwable $th
     */
    public $th;

    /**
     * Create a new event instance.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $th
     * @return void
     */
    public function __construct(Request $request, \Throwable $th)
    {
        $this->th = $th;
        $this->request = $request;
    }
}
