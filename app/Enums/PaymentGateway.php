<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentGateway: string
{
    case Paymob      = 'paymob';
    case RevenueCat  = 'revenuecat';
    case Stripe      = 'stripe';
    case Fawry       = 'fawry';
    case PayPal      = 'paypal';
    case EasyKash    = 'easykash';
    case NullAdapter = 'null_adapter';
}
