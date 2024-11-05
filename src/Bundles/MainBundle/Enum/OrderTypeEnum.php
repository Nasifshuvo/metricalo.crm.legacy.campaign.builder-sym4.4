<?php
/**
 * Created by PhpStorm.
 * * User: Unknown
 * Date: 4/15/16
 * Time: 1:25 AM
 */
namespace App\Bundles\MainBundle\Enum;

class OrderTypeEnum
{
    const TRIAL = 'trial';
    const SUBSCRIPTION = 'subscription';
    const CANCELLATION_FEE = 'cancellation_fee';
    const PAST_DUE = 'past_due';

    static protected $enum = [
        self::TRIAL => 'Trial',
        self::SUBSCRIPTION => 'Subscription',
        self::CANCELLATION_FEE => 'Cancellation Fee',
        self::PAST_DUE => 'Past Due'
    ];
}