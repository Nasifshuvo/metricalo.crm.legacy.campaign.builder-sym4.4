<?php

namespace App\Bundles\MainBundle\Twig;

use App\Bundles\Common\Symfony\Utils\Common;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PriceIntlExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('priceIntl', [$this, 'priceIntlFilter']),
            new TwigFilter('priceIntlHtml', [$this, 'priceIntlHtmlFilter']),
        ];
    }

    /**
     * Formats the value as currency based on the locale.
     * Intl locale must be in the format "de-DE".
     */
    public function priceIntlFilter($value, $currency, $intlLocale, $stripDeci = false)
    {
        $number = new \NumberFormatter($intlLocale, \NumberFormatter::CURRENCY);

        $price = $number->formatCurrency($value, $currency);

        if ($stripDeci) {
            $deciSep = strpos($price, ".") !== false ? '.' : ',';
            $parts = explode($deciSep, $price);

            return trim($parts[0]);
        }

        return trim($price);
    }

    /**
     * Formats the value as currency with HTML, based on the locale.
     * Intl locale must be in the format "de-DE".
     */
    public function priceIntlHtmlFilter($value, $currency, $intlLocale, $stripDeci = false)
    {
        $number = new \NumberFormatter($intlLocale, \NumberFormatter::CURRENCY);

        $price = trim($number->formatCurrency($value, $currency));

        return Common::priceWrapHtml($price, $stripDeci);
    }

    public function getName()
    {
        return 'price_intl_extension';
    }
}