<?php

declare(strict_types=1);

namespace App\Bundles\AffiliateBundle\Enum;

use App\Utils\Model\StaticEnum;

class LeadBlockedReasonEnum extends StaticEnum
{
    public const IP_CAMPAIGN_GEO_MISMATCH = 'ip_campaign_geo_mismatch';

    protected static array $enum = [
        self::IP_CAMPAIGN_GEO_MISMATCH => 'IP Campaign GEO Mismatch',
    ];
}
