<?php

declare(strict_types=1);

namespace App\Bundles\AffiliateBundle\Enum;

use App\Utils\Model\StaticEnum;

class ClickAbuseTypeEnum extends StaticEnum
{
    public const GENERAL_COMPLAINT = 'general_complaint';

    public const COPYRIGHT_INFRINGEMENT_AND_DMCA_VIOLATIONS = 'copyright_infringement_and_dmca_violations';

    public const TRADEMARK_INFRINGEMENT = 'trademark_infringement';

    public const VIOLENT_THREATS_AND_HARASSMENT = 'violent_threats_and_harassment';

    public const PHISHING_AND_MALWARE = 'phishing_and_malware';

    public const MISLEADING_AFFILIATE_MARKETING = 'misleading_affiliate_marketing';

    protected static array $enum = [
        self::GENERAL_COMPLAINT => 'General Complaint',
        self::COPYRIGHT_INFRINGEMENT_AND_DMCA_VIOLATIONS => 'Copyright Infringement & DMCA Violations',
        self::TRADEMARK_INFRINGEMENT => 'Trademark Infringement',
        self::VIOLENT_THREATS_AND_HARASSMENT => 'Violent Threats and Harassment',
        self::PHISHING_AND_MALWARE => 'Phishing & Malware',
        self::MISLEADING_AFFILIATE_MARKETING => 'Misleading Affiliate Marketing',
    ];

    public static function flipKeysAndLabels(): array
    {
        return array_flip(self::$enum);
    }
}
