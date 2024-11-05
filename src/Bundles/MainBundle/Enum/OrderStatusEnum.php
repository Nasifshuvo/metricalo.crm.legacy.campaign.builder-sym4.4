<?php

namespace App\Bundles\MainBundle\Enum;

class OrderStatusEnum
{
    const COMPLETED = 'completed';
    const NEEDS_SHIPPING = 'needs_shipping';
    const FAILED = 'failed';
    const REFUNDED = 'refunded';
    const UNPAID = 'unpaid';
    const CHARGE_BACK = 'charge_back';

    static protected $enum = [
        self::COMPLETED => 'Completed',
        self::NEEDS_SHIPPING => 'Needs shipping',
        self::FAILED => 'Failed',
        self::REFUNDED => 'Refunded',
        self::UNPAID => 'Unpaid',
        self::CHARGE_BACK => 'ChargeBack'
    ];
}