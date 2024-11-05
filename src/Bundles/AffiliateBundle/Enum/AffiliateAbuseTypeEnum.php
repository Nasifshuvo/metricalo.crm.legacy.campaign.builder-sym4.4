<?php

declare(strict_types=1);

namespace App\Bundles\AffiliateBundle\Enum;

use App\Utils\Model\StaticEnum;

class AffiliateAbuseTypeEnum extends StaticEnum
{
    public const SUSPECTED_MISLEADING_MARKETING = 'suspected_misleading_marketing';

    public const SUSPECTED_MISLEADING_MARKETING_FAKE_SHIPPING_FEE = 'suspected_misleading_marketing_fake_shipping_fee';

    public const SUSPECTED_MISLEADING_MARKETING_FALSE_GUARANTEE = 'suspected_misleading_marketing_false_guarantee';

    public const SUSPECTED_MISLEADING_MARKETING_GENERAL_FAKE_FEE = 'suspected_misleading_marketing_general_fake_fee';

    public const SUSPECTED_STOLEN_CARD_FRAUD = 'suspected_stolen_card_fraud';

    public const SUSPECTED_CASHBACK_FRAUD = 'suspected_cashback_fraud';

    public const SUSPECTED_CANCELLATION_FRAUD = 'suspected_cancellation_fraud';

    public const SUSPECTED_BRAND_ABUSE = 'suspected_brand_abuse';

    protected static array $enum = [
        self::SUSPECTED_MISLEADING_MARKETING => 'Suspected Misleading Marketing - General',
        self::SUSPECTED_MISLEADING_MARKETING_FAKE_SHIPPING_FEE => 'Suspected Misleading Marketing - Fake Shipping Fee',
        self::SUSPECTED_MISLEADING_MARKETING_FALSE_GUARANTEE => 'Suspected Misleading Marketing - False Guarantee',
        self::SUSPECTED_MISLEADING_MARKETING_GENERAL_FAKE_FEE => 'Suspected Misleading Marketing - General Fake Fee',
        self::SUSPECTED_STOLEN_CARD_FRAUD => 'Suspected Stolen Card Fraud',
        self::SUSPECTED_CASHBACK_FRAUD => 'Suspected Cashback Fraud',
        self::SUSPECTED_CANCELLATION_FRAUD => 'Suspected Cancellation Fraud',
        self::SUSPECTED_BRAND_ABUSE => 'Suspected Brand Abuse',
    ];

    public static function flipKeysAndLabels(): array
    {
        return array_flip(self::$enum);
    }
}
