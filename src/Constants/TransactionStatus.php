<?php

enum TransactionStatus: string
{
    /**
     * 	Not yet sent to Card Operator
     */
    case NOT_SEND = 'notSend';

    /**
     * 	Authorized
     */
    case AUTHORIZED = 'authorized';

    /**
     * 	Captured at the Card Operator
     */
    case CAPTURED = 'captured';

    /**
     * Card Operator Denied
     */
    case DENIED = 'denied';

    /**
     * 	Charged at the Card Operator
     */
    case REVERSED = 'reversed';

    /**
     * Open billet
     */
    case PENDING_BOLETO = 'pendingBoleto';

    /**
     * Cleared billet
     */
    case PAYED_BOLETO = 'payedBoleto';

    /**
     * Boleto downloaded by expiry of term
     */
    case NOT_COMPENSATED = 'notCompensated';

    /**
     * Open Pix
     */
    case PENDING_PIX = 'pendingPix';

    /**
     * Payed Pix
     */
    case PAYED_PIX = 'payedPix';

    /**
     * Pix unavailable for payment
     */
    case UNAVAILABLE_PIX = 'unavailablePix';

    /**
     * Manually canceled
     */
    case CANCEL = 'cancel';

    /**
     * 	Pay out of the system
     */
    case PAY_EXTERNAL = 'payExternal';

    /**
     * Canceled when canceling the charge
     */
    case CANCEL_BY_CONTRACT = 'cancelByContract';

    /**
     * Free
     */
    case FREE = 'free';
}
