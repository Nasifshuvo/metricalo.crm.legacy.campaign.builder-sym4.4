<?php

namespace App\Bundles\UpgradeBundle\Model\PageTemplate;

use App\Bundles\Common\Symfony\Utils\Common;
use App\Bundles\UpgradeBundle\Manager\Template\TemplateManager;
use Common\Utils\StringUtils;

class PageText extends AbstractPageVar
{

    public $text = [];

    private $templateVars = [];

    private $replacements = [];

    public static $replacementMap = [
        'user_username' => [
            'var_key' => 'website_user',
            'method' => 'getUsername',
        ],
        'user_password' => [
            'var_key' => 'website_user',
            'method' => 'getPlainPassword',
        ],
        'user_password_reset_link' => [
            'var_key' => 'website_user',
            'method' => 'getPasswordResetLink',
        ],
        'email_invoice_number' => [
            'var_key' => 'order',
            'method' => 'getCompanyRelatedId',
        ],
        'email_invoice_date' => [
            'var_key' => 'order',
            'method' => 'getAuthorizedAt',
            'format' => 'date'
        ],
        'email_refunded_date' => [
            'var_key' => 'order',
            'method' => 'getRefundedOrChargebackAt',
            'format' => 'date'
        ],
        'email_invoice_total' => [
            'var_key' => 'order',
            'method' => 'getTotal',
            'format' => 'price_iso'
        ],
        'email_invoice_total_without_vat' => [
            'var_key' => 'order',
            'method' => 'getTotalWithoutVat',
            'format' => 'price_iso'
        ],
        'email_invoice_vat_rate' => [
            'var_key' => 'order',
            'method' => 'getVatRate',
        ],
        'email_invoice_vat_charged' => [
            'var_key' => 'order',
            'method' => 'getVatCharged',
            'format' => 'price_iso'
        ],
        'subscription_trial_expiration_date' => [
            'var_key' => 'subscription',
            'method' => 'getTrialEndDate',
            'format' => 'date_time'
        ],
        'subscription_id' => [
            'var_key' => 'subscription',
            'method' => 'getUniqueIdentifier',
        ],
        'subscription_status' => [
            'var_key' => 'subscription',
            'method' => 'getStatus',
        ],
        'subscription_next_billing_date' => [
            'var_key' => 'subscription',
            'method' => 'getNextBillingDate',
            'format' => 'date'
        ],
        'subscription_cancellation_link' => [
            'var_key' => 'subscription_cancellation_link',
        ],
        'website_terms_and_conditions_link' => [
            'var_key' => 'website_terms_and_conditions_link',
        ],
        'order_subscription_price' => [
            'var_key' => 'order',
            'method' => 'getSubscriptionPrice',
            'format' => 'price'
        ],
        'order_subscription_trial_days' => [
            'var_key' => 'order',
            'method' => 'getSubscriptionTrialDays',
        ],
        'order_subscription_interval_days' => [
            'var_key' => 'order',
            'method' => 'getSubscriptionIntervalDays',
        ],
        'order_paid_interval_days' => [
            'var_key' => 'order',
            'method' => 'getPaidIntervalDays',
        ],

        'customer_full_name' => [
            'var_key' => 'customer',
            'method' => 'getFullName',
        ],
        'customer_address' => [
            'var_key' => 'customer',
            'method' => 'getAddress',
        ],
        'customer_city' => [
            'var_key' => 'customer',
            'method' => 'getCity',
        ],
        'customer_postcode' => [
            'var_key' => 'customer',
            'method' => 'getPostcode',
        ],
        'customer_country' => [
            'var_key' => 'customer',
            'method' => 'getFullCountry',
        ],
        'customer_email' => [
            'var_key' => 'customer',
            'method' => 'getEmail',
        ],

        'order_total' => [
            'var_key' => 'order',
            'method' => 'getTotal',
            'format' => 'price'
        ],

        'product_name' => [
            'var_key' => 'product',
            'method' => 'getName',
        ],
        'product_description' => [
            'var_key' => 'product',
            'method' => 'getDescription',
        ],
        'product_benefits' => [
            'var_key' => 'product',
            'method' => 'getAllBenefits',
        ],
        'product_price' => [
            'var_key' => 'product',
            'method' => 'getPrice',
            'format' => 'price'
        ],
        'product_currency' => [
            'var_key' => 'product',
            'method' => 'getCurrency',
        ],
        'product_subscription_price' => [
            'var_key' => 'product',
            'method' => 'getSubscriptionPrice',
            'format' => 'price'
        ],
        'product_subscription_trial_days' => [
            'var_key' => 'product',
            'method' => 'getSubscriptionTrialDays',
        ],
        'product_subscription_interval_days' => [
            'var_key' => 'product',
            'method' => 'getSubscriptionIntervalDays',
        ],

        'website_name' => [
            'var_key' => 'service',
            'method' => 'getName',
        ],
        'website_logo_path' => [
            'var_key' => 'service',
            'method' => 'getLogoImagePath',
        ],
        'website_description' => [
            'var_key' => 'service',
            'method' => 'getDescription',
        ],
        'website_domain' => [
            'var_key' => 'service',
            'method' => 'getDomainNoSchema',
        ],
        'website_support_number' => [
            'var_key' => 'service',
            'method' => 'getSupportPhone',
        ],
        'website_support_email' => [
            'var_key' => 'service',
            'method' => 'getSupportEmail',
        ],

        'company_name' => [
            'var_key' => 'service',
            'method' => 'getCompanyName',
        ],
        'company_business_number' => [
            'var_key' => 'service',
            'method' => 'getBusinessNumber',
        ],
        'company_address' => [
            'var_key' => 'service',
            'method' => 'getCompanyAddress',
        ],
        'company_city' => [
            'var_key' => 'service',
            'method' => 'getCompanyCity',
        ],
        'company_postcode' => [
            'var_key' => 'service',
            'method' => 'getCompanyPostcode',
        ],
        'company_country' => [
            'var_key' => 'service',
            'method' => 'getCompanyCountry',
        ],
        'company_vat_number' => [
            'var_key' => 'service',
            'method' => 'getVatNumber',
        ],

        'campaign_slug' => [
            'var_key' => 'campaign',
            'method' => 'getSlug',
        ],
        'campaign_skill_game_item' => [
            'var_key' => 'campaign',
            'method' => 'getSecondaryAdvertisedItemName',
        ],
        'descriptor' => [
            'var_key' => 'descriptor',
        ],
        'contest_expires_datetime' => [
            'var_key' => 'contest_expires_datetime',
        ],
        'free_entry_link' => [
            'var_key' => 'free_entry_link',
        ],
        'direct_signup_link' => [
            'var_key' => 'direct_signup_link',
        ],
        'skill_game_item_price' => [
            'var_key' => 'skill_game_item',
            'method' => 'getPrice',
            'format' => 'price'
        ],
        'skill_game_item_price_iso' => [
            'var_key' => 'skill_game_item',
            'method' => 'getPrice',
            'format' => 'price_iso'
        ],
        'abuse_case_id' => [
            'var_key' => 'abuse_case_id',
        ],
        'dynamic_skill_game_item_name' => [
            'var_key' => 'lead',
            'method' => 'getDynamicSkillGameItemName',
        ],
        'dynamic_skill_game_item_image' => [
            'var_key' => 'lead',
            'method' => 'getDynamicSkillGameItemImage',
        ],
    ];

    private function getValueForPlaceholder($placeholder)
    {

        if (!array_key_exists($placeholder, self::$replacementMap))
            return false;

        $replacement = self::$replacementMap[$placeholder];

        $value = $this->templateVars[$replacement['var_key']];

        if (array_key_exists('method', $replacement)) {
            $method = $replacement['method'];
            $object = $value;

            $value = $object->{"$method"}();

            // must be object with getCurrency to format
            if (array_key_exists('format', $replacement)) {


                if ($replacement['format'] == 'price') {

                    $lead = $this->templateVars['lead'];
                    $value = Common::formatCurrency($value, $object->getCurrency(), $lead->getIntlLocale(), true);
                }
                if ($replacement['format'] == 'price_iso') {

                    $value = $value . ' ' . $object->getCurrency();
                }
                if ($replacement['format'] == 'price_html') {

                    $lead = $this->templateVars['lead'];
                    $value = Common::formatCurrencyHtml($value, $object->getCurrency(), $lead->getIntlLocale(), true);
                }


                if ($value instanceof \DateTime) {

                    if ($replacement['format'] == 'date') {
                        $value = $value->format('Y-m-d');
                    }
                    if ($replacement['format'] == 'date_time') {
                        $value = $value->format('Y-m-d H:i');
                    }
                }
            }
        }

        return $value;
    }

    /**
     * @param TemplateManager $templateManager
     * @return $this|false
     * @throws \Exception
     */
    public function onloadtext(TemplateManager $templateManager)
    {
        if (empty($this->config))
            return false;

        // Load config text first
        $this->text = $templateManager->getTextPlaceholders($this->getPage(), true);

        foreach ($this->config as $key => $dbtext) {

            $pattern = '/%(.*?)%/'; // This regex pattern matches the placeholders

            preg_match_all($pattern, $dbtext, $matches);

            foreach ($matches[1] as $placeholder) {

                $value = $this->getValueForPlaceholder($placeholder);

                if (!$value) {
                    // If a value for the placeholder is not found, skip to the next iteration
                    continue;
                }

                $dbtext = str_replace('%' . $placeholder . '%', $value, $dbtext);
            }

            /*
            while (strpos($dbtext, '%') !== false) {

                $placeholder = StringUtils::getStringBetween($dbtext, '%', '%');

                $value = $this->getValueForPlaceholder($placeholder);

                if (!$value) {
                    //throw new \Exception('Placeholder config for "' . $placeholder . '" not found in template var map.');
                    continue;
                }

                $dbtext = str_replace('%'.$placeholder.'%', $value, $dbtext);;
            }
            */
            $this->text[$key] = $dbtext;
        }

        return $this;
    }

    /**
     * @param $mixed
     * @param null $value
     * @return $this
     */
    public function addTemplateVar($key, $value)
    {
        $this->templateVars[$key] = $value;

        return $this;
    }

    public function get($key)
    {
        if (!is_array($this->text))
            return $key;

        $hexKey = bin2hex($key);

        if (!array_key_exists($hexKey, $this->text))
            return $key;

        return $this->text[$hexKey];
    }

    /**
     * @param $configArr
     * @return array
     */
    public function getAdminFields($configArr)
    {
        if (!is_array($configArr))
            return [];

        $formFields = [];
        foreach ($configArr as $textField) {

            // lightweight config
            $key = $textField;
            $fieldType = 'text';
            $opts = [
                'required'  => false,
            ];

            // If field is array, it's a full config
            if (is_array($textField)) {

                $key = $textField['field']['key'];
                $fieldType = $textField['field']['type'];

                if (array_key_exists('options', $textField['field'])) {
                    $opts = array_merge($textField['field']['options'], $opts);
                }

            }

            // set current value
            $opts['label'] = $key;
            $opts['data'] = $this->get($key);

            $formFields[] = [bin2hex($key), $fieldType, $opts];
        }

        return $formFields;
    }
}