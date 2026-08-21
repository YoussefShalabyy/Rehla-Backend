<?php

declare(strict_types=1);

namespace App\Enums;

enum AdminPermission: string
{
    case ManageListings     = 'manage_listings';
    case ManagePromoCodes   = 'manage_promo_codes';
    case ManageUsers        = 'manage_users';
    case ManageBookings     = 'manage_bookings';
    case ManageReviews      = 'manage_reviews';
    case ManageSettings     = 'manage_settings';
    case ManageDestinations = 'manage_destinations';
    case ManageLeads        = 'manage_leads';
}
