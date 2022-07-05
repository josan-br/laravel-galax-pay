<?php

namespace JosanBr\GalaxPay\Constants;

enum PaymentMethod: string
{
    case BILLET = 'boleto';

    case CREDIT_CARD = 'creditcard';

    case PIX = 'pix';
}
