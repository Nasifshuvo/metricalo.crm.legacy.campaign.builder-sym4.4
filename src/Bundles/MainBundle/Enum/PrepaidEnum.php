<?php

namespace App\Bundles\MainBundle\Enum;

class PrepaidEnum
{
    const PREPAID = 'prepaid';
    const NOT_PREPAID = 'not_prepaid';

    static protected $enum = [
        self::PREPAID => 'Prepaid',
        self::NOT_PREPAID => 'Not Prepaid',
    ];
}