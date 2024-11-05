<?php

namespace App\Bundles\Common\Symfony\Utils;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\HttpFoundation\Request;

class Common
{

    public static function ensureArray($val)
    {
        $arr = [];

        if (!empty($val)) {
            if (is_array($val)) {
                $arr = array_merge($arr, $val);
            } else {
                $arr[] = $val;
            }
        }

        return $arr;
    }

    public static function countryCodeTransformValid($code) {
        if (trim(strtoupper($code)) == 'EN') {
            $code = 'GB';
        }
        return $code;
    }

    public static function enforceHTTPS($url)
    {
        return str_replace('http:', 'https:', $url);
    }

    public static function randColor() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public static function ifEmptyNull($val) {
        if (empty($val))
            return null;

        return $val;
    }

    public static function camelCaseToSnakeCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }


    public static function snakeCaseToCamelCase($input)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $input))));
    }


    public static function arrayValueAsKeyRemoveEmpty($array, $keyName)
    {

        $newArray = [];
        foreach ($array as $item) {

            $newArray[$item[$keyName]] = $item;
        }

        return $newArray;
    }

    public static function arrayValueMergedAsKeyRemoveEmpty($array, $keyName, $keyName2)
    {

        $newArray = [];
        foreach ($array as $item) {

            $newArray[$item[$keyName] . '_' . $item[$keyName2]] = $item;
        }

        return $newArray;
    }

    public static function generateIPUserAgentHash(Request $request)
    {
        return md5($request->getClientIp() . $request->headers->get('User-Agent'));
    }

    public static function generateIPUserAgentHashRaw($ip, $userAgent) {
        return md5($ip . $userAgent);
    }

    public static function getDaysSinceDateTime($datetime)
    {

        if (!$datetime)
            return null;

        $now = new \DateTime();

        return (int)$datetime->diff($now)->format("%a");
    }

    public static function getSecondsBetweenDateTimes($datetime1, $datetime2)
    {
        return (int)$datetime1->diff($datetime2)->format("%i");
    }

    public static function getMinutesSinceDateTime($datetime)
    {

        $now = new \DateTime();
        $timeDifference = $datetime->diff($now);

        $minutes = $timeDifference->days * 24 * 60;
        $minutes += $timeDifference->h * 60;
        $minutes += $timeDifference->i;

        return (int)$minutes;
    }

    public static function normalizeExcelDateImport($date)
    {

        $date = trim(str_replace(' AM', null, $date));

        $datetimeParts = explode(' ', $date);

        if (strpos($datetimeParts[0], '-') !== false) {
            return \DateTime::createFromFormat('Y-m-d', $datetimeParts[0]);
        } else {
            return \DateTime::createFromFormat('d/m/Y', $datetimeParts[0]);
        }
    }

    public static function detectAndExtractDate($date)
    {

        $date = trim(str_replace(' 00:00:00', null, $date));

        if (strpos($date, '/') !== false) {
            return \DateTime::createFromFormat('Y/m/d', $date);
        } else if (strpos($date, '-') !== false) {
            return \DateTime::createFromFormat('Y-m-d', $date);
        } else {
            return \DateTime::createFromFormat('d.m.Y', $date);
        }
    }

    public static function removeAccents($str)
    {
        $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ', 'Ά', 'ά', 'Έ', 'έ', 'Ό', 'ό', 'Ώ', 'ώ', 'Ί', 'ί', 'ϊ', 'ΐ', 'Ύ', 'ύ', 'ϋ', 'ΰ', 'Ή', 'ή');
        $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o', 'Α', 'α', 'Ε', 'ε', 'Ο', 'ο', 'Ω', 'ω', 'Ι', 'ι', 'ι', 'ι', 'Υ', 'υ', 'υ', 'υ', 'Η', 'η');
        return str_replace($a, $b, $str);
    }


    public static function countryCodeToISO_3166_1($country)
    {
        $countries = array(
            'AF' => 'AFG', //Afghanistan
            'AX' => 'ALA', //&#197;land Islands
            'AL' => 'ALB', //Albania
            'DZ' => 'DZA', //Algeria
            'AS' => 'ASM', //American Samoa
            'AD' => 'AND', //Andorra
            'AO' => 'AGO', //Angola
            'AI' => 'AIA', //Anguilla
            'AQ' => 'ATA', //Antarctica
            'AG' => 'ATG', //Antigua and Barbuda
            'AR' => 'ARG', //Argentina
            'AM' => 'ARM', //Armenia
            'AW' => 'ABW', //Aruba
            'AU' => 'AUS', //Australia
            'AT' => 'AUT', //Austria
            'AZ' => 'AZE', //Azerbaijan
            'BS' => 'BHS', //Bahamas
            'BH' => 'BHR', //Bahrain
            'BD' => 'BGD', //Bangladesh
            'BB' => 'BRB', //Barbados
            'BY' => 'BLR', //Belarus
            'BE' => 'BEL', //Belgium
            'BZ' => 'BLZ', //Belize
            'BJ' => 'BEN', //Benin
            'BM' => 'BMU', //Bermuda
            'BT' => 'BTN', //Bhutan
            'BO' => 'BOL', //Bolivia
            'BQ' => 'BES', //Bonaire, Saint Estatius and Saba
            'BA' => 'BIH', //Bosnia and Herzegovina
            'BW' => 'BWA', //Botswana
            'BV' => 'BVT', //Bouvet Islands
            'BR' => 'BRA', //Brazil
            'IO' => 'IOT', //British Indian Ocean Territory
            'BN' => 'BRN', //Brunei
            'BG' => 'BGR', //Bulgaria
            'BF' => 'BFA', //Burkina Faso
            'BI' => 'BDI', //Burundi
            'KH' => 'KHM', //Cambodia
            'CM' => 'CMR', //Cameroon
            'CA' => 'CAN', //Canada
            'CV' => 'CPV', //Cape Verde
            'KY' => 'CYM', //Cayman Islands
            'CF' => 'CAF', //Central African Republic
            'TD' => 'TCD', //Chad
            'CL' => 'CHL', //Chile
            'CN' => 'CHN', //China
            'CX' => 'CXR', //Christmas Island
            'CC' => 'CCK', //Cocos (Keeling) Islands
            'CO' => 'COL', //Colombia
            'KM' => 'COM', //Comoros
            'CG' => 'COG', //Congo
            'CD' => 'COD', //Congo, Democratic Republic of the
            'CK' => 'COK', //Cook Islands
            'CR' => 'CRI', //Costa Rica
            'CI' => 'CIV', //Côte d\'Ivoire
            'HR' => 'HRV', //Croatia
            'CU' => 'CUB', //Cuba
            'CW' => 'CUW', //Curaçao
            'CY' => 'CYP', //Cyprus
            'CZ' => 'CZE', //Czech Republic
            'DK' => 'DNK', //Denmark
            'DJ' => 'DJI', //Djibouti
            'DM' => 'DMA', //Dominica
            'DO' => 'DOM', //Dominican Republic
            'EC' => 'ECU', //Ecuador
            'EG' => 'EGY', //Egypt
            'SV' => 'SLV', //El Salvador
            'GQ' => 'GNQ', //Equatorial Guinea
            'ER' => 'ERI', //Eritrea
            'EE' => 'EST', //Estonia
            'ET' => 'ETH', //Ethiopia
            'FK' => 'FLK', //Falkland Islands
            'FO' => 'FRO', //Faroe Islands
            'FJ' => 'FIJ', //Fiji
            'FI' => 'FIN', //Finland
            'FR' => 'FRA', //France
            'GF' => 'GUF', //French Guiana
            'PF' => 'PYF', //French Polynesia
            'TF' => 'ATF', //French Southern Territories
            'GA' => 'GAB', //Gabon
            'GM' => 'GMB', //Gambia
            'GE' => 'GEO', //Georgia
            'DE' => 'DEU', //Germany
            'GH' => 'GHA', //Ghana
            'GI' => 'GIB', //Gibraltar
            'GR' => 'GRC', //Greece
            'GL' => 'GRL', //Greenland
            'GD' => 'GRD', //Grenada
            'GP' => 'GLP', //Guadeloupe
            'GU' => 'GUM', //Guam
            'GT' => 'GTM', //Guatemala
            'GG' => 'GGY', //Guernsey
            'GN' => 'GIN', //Guinea
            'GW' => 'GNB', //Guinea-Bissau
            'GY' => 'GUY', //Guyana
            'HT' => 'HTI', //Haiti
            'HM' => 'HMD', //Heard Island and McDonald Islands
            'VA' => 'VAT', //Holy See (Vatican City State)
            'HN' => 'HND', //Honduras
            'HK' => 'HKG', //Hong Kong
            'HU' => 'HUN', //Hungary
            'IS' => 'ISL', //Iceland
            'IN' => 'IND', //India
            'ID' => 'IDN', //Indonesia
            'IR' => 'IRN', //Iran
            'IQ' => 'IRQ', //Iraq
            'IE' => 'IRL', //Republic of Ireland
            'IM' => 'IMN', //Isle of Man
            'IL' => 'ISR', //Israel
            'IT' => 'ITA', //Italy
            'JM' => 'JAM', //Jamaica
            'JP' => 'JPN', //Japan
            'JE' => 'JEY', //Jersey
            'JO' => 'JOR', //Jordan
            'KZ' => 'KAZ', //Kazakhstan
            'KE' => 'KEN', //Kenya
            'KI' => 'KIR', //Kiribati
            'KP' => 'PRK', //Korea, Democratic People\'s Republic of
            'KR' => 'KOR', //Korea, Republic of (South)
            'KW' => 'KWT', //Kuwait
            'KG' => 'KGZ', //Kyrgyzstan
            'LA' => 'LAO', //Laos
            'LV' => 'LVA', //Latvia
            'LB' => 'LBN', //Lebanon
            'LS' => 'LSO', //Lesotho
            'LR' => 'LBR', //Liberia
            'LY' => 'LBY', //Libya
            'LI' => 'LIE', //Liechtenstein
            'LT' => 'LTU', //Lithuania
            'LU' => 'LUX', //Luxembourg
            'MO' => 'MAC', //Macao S.A.R., China
            'MK' => 'MKD', //Macedonia
            'MG' => 'MDG', //Madagascar
            'MW' => 'MWI', //Malawi
            'MY' => 'MYS', //Malaysia
            'MV' => 'MDV', //Maldives
            'ML' => 'MLI', //Mali
            'MT' => 'MLT', //Malta
            'MH' => 'MHL', //Marshall Islands
            'MQ' => 'MTQ', //Martinique
            'MR' => 'MRT', //Mauritania
            'MU' => 'MUS', //Mauritius
            'YT' => 'MYT', //Mayotte
            'MX' => 'MEX', //Mexico
            'FM' => 'FSM', //Micronesia
            'MD' => 'MDA', //Moldova
            'MC' => 'MCO', //Monaco
            'MN' => 'MNG', //Mongolia
            'ME' => 'MNE', //Montenegro
            'MS' => 'MSR', //Montserrat
            'MA' => 'MAR', //Morocco
            'MZ' => 'MOZ', //Mozambique
            'MM' => 'MMR', //Myanmar
            'NA' => 'NAM', //Namibia
            'NR' => 'NRU', //Nauru
            'NP' => 'NPL', //Nepal
            'NL' => 'NLD', //Netherlands
            'AN' => 'ANT', //Netherlands Antilles
            'NC' => 'NCL', //New Caledonia
            'NZ' => 'NZL', //New Zealand
            'NI' => 'NIC', //Nicaragua
            'NE' => 'NER', //Niger
            'NG' => 'NGA', //Nigeria
            'NU' => 'NIU', //Niue
            'NF' => 'NFK', //Norfolk Island
            'MP' => 'MNP', //Northern Mariana Islands
            'NO' => 'NOR', //Norway
            'OM' => 'OMN', //Oman
            'PK' => 'PAK', //Pakistan
            'PW' => 'PLW', //Palau
            'PS' => 'PSE', //Palestinian Territory
            'PA' => 'PAN', //Panama
            'PG' => 'PNG', //Papua New Guinea
            'PY' => 'PRY', //Paraguay
            'PE' => 'PER', //Peru
            'PH' => 'PHL', //Philippines
            'PN' => 'PCN', //Pitcairn
            'PL' => 'POL', //Poland
            'PT' => 'PRT', //Portugal
            'PR' => 'PRI', //Puerto Rico
            'QA' => 'QAT', //Qatar
            'RE' => 'REU', //Reunion
            'RO' => 'ROU', //Romania
            'RU' => 'RUS', //Russia
            'RW' => 'RWA', //Rwanda
            'BL' => 'BLM', //Saint Barth&eacute;lemy
            'SH' => 'SHN', //Saint Helena
            'KN' => 'KNA', //Saint Kitts and Nevis
            'LC' => 'LCA', //Saint Lucia
            'MF' => 'MAF', //Saint Martin (French part)
            'SX' => 'SXM', //Sint Maarten / Saint Matin (Dutch part)
            'PM' => 'SPM', //Saint Pierre and Miquelon
            'VC' => 'VCT', //Saint Vincent and the Grenadines
            'WS' => 'WSM', //Samoa
            'SM' => 'SMR', //San Marino
            'ST' => 'STP', //S&atilde;o Tom&eacute; and Pr&iacute;ncipe
            'SA' => 'SAU', //Saudi Arabia
            'SN' => 'SEN', //Senegal
            'RS' => 'SRB', //Serbia
            'SC' => 'SYC', //Seychelles
            'SL' => 'SLE', //Sierra Leone
            'SG' => 'SGP', //Singapore
            'SK' => 'SVK', //Slovakia
            'SI' => 'SVN', //Slovenia
            'SB' => 'SLB', //Solomon Islands
            'SO' => 'SOM', //Somalia
            'ZA' => 'ZAF', //South Africa
            'GS' => 'SGS', //South Georgia/Sandwich Islands
            'SS' => 'SSD', //South Sudan
            'ES' => 'ESP', //Spain
            'LK' => 'LKA', //Sri Lanka
            'SD' => 'SDN', //Sudan
            'SR' => 'SUR', //Suriname
            'SJ' => 'SJM', //Svalbard and Jan Mayen
            'SZ' => 'SWZ', //Swaziland
            'SE' => 'SWE', //Sweden
            'CH' => 'CHE', //Switzerland
            'SY' => 'SYR', //Syria
            'TW' => 'TWN', //Taiwan
            'TJ' => 'TJK', //Tajikistan
            'TZ' => 'TZA', //Tanzania
            'TH' => 'THA', //Thailand
            'TL' => 'TLS', //Timor-Leste
            'TG' => 'TGO', //Togo
            'TK' => 'TKL', //Tokelau
            'TO' => 'TON', //Tonga
            'TT' => 'TTO', //Trinidad and Tobago
            'TN' => 'TUN', //Tunisia
            'TR' => 'TUR', //Turkey
            'TM' => 'TKM', //Turkmenistan
            'TC' => 'TCA', //Turks and Caicos Islands
            'TV' => 'TUV', //Tuvalu
            'UG' => 'UGA', //Uganda
            'UA' => 'UKR', //Ukraine
            'AE' => 'ARE', //United Arab Emirates
            'GB' => 'GBR', //United Kingdom
            'US' => 'USA', //United States
            'UM' => 'UMI', //United States Minor Outlying Islands
            'UY' => 'URY', //Uruguay
            'UZ' => 'UZB', //Uzbekistan
            'VU' => 'VUT', //Vanuatu
            'VE' => 'VEN', //Venezuela
            'VN' => 'VNM', //Vietnam
            'VG' => 'VGB', //Virgin Islands, British
            'VI' => 'VIR', //Virgin Island, U.S.
            'WF' => 'WLF', //Wallis and Futuna
            'EH' => 'ESH', //Western Sahara
            'YE' => 'YEM', //Yemen
            'ZM' => 'ZMB', //Zambia
            'ZW' => 'ZWE', //Zimbabwe
        );
        $iso_code = isset($countries[$country]) ? $countries[$country] : $country;
        return $iso_code;
    }

    public static function countryToCountryCode($name)
    {
        return self::countryCodeToCountryName($name, true);
    }

    public static function getLanguageFlagCode($langCode)
    {
        return self::countryCodeToCountryName(self::getLanguageFlagCountryAsCode($langCode));
    }

    public static function getLanguageFlagCountryAsCode($langCode)
    {

        $matrix = [
            'ms' => 'MY',
            'ja' => 'JP',
            'da' => 'DK',
            'nb' => 'NO',
            'sv' => 'SE',
            'nd' => 'ZW',
            'sn' => 'ZW',
            'xh' => 'ZA',
            'zu' => 'ZA',
        ];

        if (array_key_exists($langCode, $matrix))
            return $matrix[$langCode];

        return strtoupper($langCode);
    }

    public static function countryCodeToCountryName($code, $flipKeyValues = false)
    {

        $codeForLookup = strtoupper($code);

        if ($codeForLookup == 'EN') {
            $codeForLookup = 'GB';
        }

        $countryList = array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas the',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island (Bouvetoya)',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros the',
            'CD' => 'Congo',
            'CG' => 'Congo the',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote d\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FO' => 'Faroe Islands',
            'FK' => 'Falkland Islands (Malvinas)',
            'FJ' => 'Fiji the Fiji Islands',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia the',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Republic of Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KP' => 'Korea',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyz Republic',
            'LA' => 'Lao',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'AN' => 'Netherlands Antilles',
            'NL' => 'Netherlands',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn Islands',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia, Somali Republic',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard & Jan Mayen Islands',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States of America',
            'UM' => 'United States Minor Outlying Islands',
            'VI' => 'United States Virgin Islands',
            'UY' => 'Uruguay, Eastern Republic of',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        );

        if ($flipKeyValues) {
            $countryList = array_flip($countryList);
        }

        if (!array_key_exists($codeForLookup, $countryList)) {
            return $code;
        } else {
            return $countryList[$codeForLookup];
        }
    }

    public static function randomKey($length)
    {
        $pool = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

        $key = '';
        for ($i = 0; $i < $length; $i++) {
            $key .= $pool[mt_rand(0, count($pool) - 1)];
        }
        return $key;
    }

    public static function randomName()
    {
        $firstname = array(
            'Zoe',
            'Orlene',
            'Cher',
            'Edmee',
            'Albertine',
            'Carine',
            'Raina',
            'Charlotte',
            'Noemi',
            'Patricia',
            'Arlette',
            'Renee',
            'Henriette',
            'Antoinette',
            'Dominique',
            'Delit',
            'Veronique',
            'Delmare',
            'Genevieve',
            'Patience'
        );

        $lastname = array(
            'Cyr',
            'Bouvier',
            'LaGarde',
            'Letourneau',
            'Goulet',
            'Barrientos',
            'Desforges',
            'Charlebois',
            'Tanguay',
            'Daigneault',
            'Pitre',
            'Authier',
            'Fournier',
            'Senneville',
            'Bussiere',
            'Rivard',
            'Martel',
            'Cormier',
            'Dagenais'
        );

        $name = $firstname[rand(0, count($firstname) - 1)];
        $name .= ' ';
        $name .= $lastname[rand(0, count($lastname) - 1)];

        return $name;
    }

    public static function getCanadaStates()
    {

        $states = [
            'AB' => 'Alberta',
            'BC' => 'British Columbia',
            'MB' => 'Manitoba',
            'NB' => 'New Brunswick',
            'NL' => 'Newfoundland and Labrador',
            'NS' => 'Nova Scotia',
            'ON' => 'Ontario',
            'PE' => 'Prince Edward Island',
            'QC' => 'Quebec',
            'SK' => 'Saskatchewan',
            'NT' => 'Northwest Territories',
            'NU' => 'Nunavut',
            'YT' => 'Yukon',
        ];

        return $states;
    }

    public static function characterLimiter($str, $n = 50, $end_char = '')
    {

        if (strlen($str) < $n) {
            return $str;
        }

        $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

        if (strlen($str) <= $n) {
            return $str;
        }

        $out = "";
        foreach (explode(' ', trim($str)) as $val) {
            $out .= $val . ' ';

            if (strlen($out) >= $n) {
                $out = trim($out);
                return (strlen($out) == strlen($str)) ? $out : $out . $end_char;
            }
        }
    }

    public static function generateRandomId($min, $max)
    {
        return substr(strtolower(md5(microtime() . mt_rand(1000, 9999))), 0, mt_rand($min, $max));
    }

    public static function getStartOfWeekDate($date = null)
    {
        if ($date instanceof \DateTime) {
            $date = clone $date;
        } else if (!$date) {
            $date = new \DateTime();
        } else {
            $date = new \DateTime($date);
        }

        $date->setTime(0, 0, 0);

        if ($date->format('N') == 1) {
            // If the date is already a Monday, return it as-is
            return $date;
        } else {
            // Otherwise, return the date of the nearest Monday in the past
            // This includes Sunday in the previous week instead of it being the start of a new week
            return $date->modify('last monday');
        }
    }

    public static function getCurrencySymbol($currency)
    {

        if ($currency == 'DKK' || $currency == 'NOK' || $currency == 'SEK') {
            return 'kr';
        }

        if ($currency == 'EUR') {
            return '€';
        }

        if ($currency == 'GBP') {
            return '£';
        }

        if ($currency == 'PLN') {
            return 'zł';
        }

        if ($currency == 'USD' || $currency == 'NZD' || $currency == 'CLP' || $currency == 'COP') {
            return '$';
        }

        if ($currency == 'HUF') {
            return 'Ft';
        }

        if ($currency == 'MXN') {
            return 'MX$';
        }

        if ($currency == 'CHF') {
            return 'fr.';
        }

        if ($currency == 'AUD') {
            return '$';
        }

        if ($currency == 'CAD') {
            return '$';
        }

        if ($currency == 'SGD') {
            return '$';
        }

        if ($currency == 'MYR') {
            return 'RM';
        }

        if ($currency == 'JPY') {
            return '¥';
        }

        if ($currency == 'IDR') {
            return 'Rp';
        }

        if ($currency == 'PHP') {
            return '₱';
        }

        if ($currency == 'CZK') {
            return 'Kč';
        }

        return $currency;
    }

    public static function wrapParameters($endpoint, $data)
    {
        foreach ($data as $key => $value) {
            if (strpos($endpoint, '{' . $key . '}') !== false) {
                $endpoint = str_replace('{' . $key . '}', $value, $endpoint);
            } else {

                if (strpos($endpoint, '?') === false) {
                    $endpoint .= '?';
                } else {
                    $endpoint .= '&';
                }

                $endpoint .= $key . '=' . $value;
            }
        }
        return $endpoint;
    }

    public static function formatPriceFromLocale($number, $currencyCode, $locale, $wrapTrailingZeroes = false)
    {

        $map = [
            'en_ca' => "%symbol%%value%",
            'fr_ca' => "%value% %symbol%",
            'pl_pl' => "%value% %symbol%",

            'fr_fr' => '%value% %symbol%',
            'en_nz' => '%symbol%%value%',
            'sv_se' => '%value% %symbol%',
            'nb_no' => '%symbol% %value%',
            'de_ch' => '%symbol% %value%',
            'fr_ch' => '%value% %symbol%',

            'fi_fi' => '%value% %symbol%',
            'it_it' => '%value% %symbol%',
            'my_my' => '%symbol%%value%',
            'ms_my' => '%symbol%%value%',

            'en_sg' => '%symbol%%value%',
            'my_sg' => '%symbol%%value%',
            'fr_be' => '%value% %symbol%',
            'nl_be' => '%symbol% %value%',

            'mx_mx' => '%symbol% %value%',
            'es_mx' => '%symbol% %value%',
            'hu_hu' => '%value% %symbol%',
            'es_cl' => '%value% %symbol%',
            'cl_cl' => '%value% %symbol%',

            'en_en' => '%symbol% %value%',
        ];

        if (!array_key_exists($locale, $map)) {
            $locale = 'en_en';
        }

        $strategy = $map[$locale];

        $currencySymbol = self::getCurrencySymbol($currencyCode);
        $formattedCurrency = "<span class='currency-span'>" . $currencySymbol . "</span>";

        $number = str_replace('.00', '', $number);
        $number = str_replace(',00', '', $number);

        $trailingDecimals = null;

        if ($wrapTrailingZeroes != false) {

            // Todo, allow decimals in futuere
            $trailingDecimals = "<sup class='deci'>,00</sup>";
        }

        $formattedValue = "<span class='cost-span'>" . $number . "</span>" . $trailingDecimals;

        $formatted = str_replace(['%value%', '%symbol%'], [$formattedValue, $formattedCurrency], $strategy);

        return $formatted;
    }

    public static function priceWrapHtml($price, $stripDecimals = false)
    {
        $deciSep = ',';

        if (strpos($price, ".") !== false) {
            $deciSep = '.';
        }

        $parts = explode($deciSep, $price);

        if ($stripDecimals) {
            return "<span class='cost-span'>" . $parts[0] . "</span>";
        }

        return "<span class='cost-span'>" . $parts[0] . "</span><span class='deci'>".$deciSep . $parts[1]."</span>";
    }

    public static function internationalPhoneNumber($localNumber, $region)
    {

        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $numberProto = $phoneUtil->parseAndKeepRawInput($localNumber, $region);
        } catch (\Exception $e) {
            return null;
        }

        $number = $phoneUtil->format($numberProto, PhoneNumberFormat::INTERNATIONAL);

        return preg_replace('/\s+/', '', $number);
    }

    public static function getPhoneNumberPrefix($localNumber, $region) {

        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $numberProto = $phoneUtil->parseAndKeepRawInput($localNumber, $region);
        } catch (\Exception $e) {
            return null;
        }

        return $numberProto->getCountryCode();
    }

    public static function getContestExpirationDate()
    {

        $now = new \DateTime();
        $month = $now->format('m');

        /*
        if ($month == 12) {
            $thisYear = new \DateTime();
            $thisYear->add(new \DateInterval('P1Y'));

            return '31/5/' . $thisYear->format("Y");

        } else */if ($month <= 5) {
            return '30/06/' . $now->format("Y");
        } else {
            return '31/12/' . $now->format("Y");
        }
    }

    public static function getContestStartDate()
    {
        $now = new \DateTime();
        $month = $now->format('m');

        /*
        if ($month == 12) {
            $thisYear = new \DateTime();
            $thisYear->add(new \DateInterval('P1Y'));

            return '31/5/' . $thisYear->format("Y");

        } else */
        if ($month <= 5) {
            return '01/01/' . $now->format("Y");
        } else {
            return '01/06/' . $now->format("Y");
        }
    }

    public static function getAllCountries()
    {

        return array(
            'AF' => 'Afghanistan',
            'AX' => 'Aland Islands',
            'AL' => 'Albania',
            'DZ' => 'Algeria',
            'AS' => 'American Samoa',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguilla',
            'AQ' => 'Antarctica',
            'AG' => 'Antigua and Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaijan',
            'BS' => 'Bahamas the',
            'BH' => 'Bahrain',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Belarus',
            'BE' => 'Belgium',
            'BZ' => 'Belize',
            'BJ' => 'Benin',
            'BM' => 'Bermuda',
            'BT' => 'Bhutan',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia and Herzegovina',
            'BW' => 'Botswana',
            'BV' => 'Bouvet Island (Bouvetoya)',
            'BR' => 'Brazil',
            'IO' => 'British Indian Ocean Territory (Chagos Archipelago)',
            'VG' => 'British Virgin Islands',
            'BN' => 'Brunei Darussalam',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'KH' => 'Cambodia',
            'CM' => 'Cameroon',
            'CA' => 'Canada',
            'CV' => 'Cape Verde',
            'KY' => 'Cayman Islands',
            'CF' => 'Central African Republic',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Christmas Island',
            'CC' => 'Cocos (Keeling) Islands',
            'CO' => 'Colombia',
            'KM' => 'Comoros the',
            'CD' => 'Congo',
            'CG' => 'Congo the',
            'CK' => 'Cook Islands',
            'CR' => 'Costa Rica',
            'CI' => 'Cote d\'Ivoire',
            'HR' => 'Croatia',
            'CU' => 'Cuba',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'DJ' => 'Djibouti',
            'DM' => 'Dominica',
            'DO' => 'Dominican Republic',
            'EC' => 'Ecuador',
            'EG' => 'Egypt',
            'SV' => 'El Salvador',
            'GQ' => 'Equatorial Guinea',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'ET' => 'Ethiopia',
            'FO' => 'Faroe Islands',
            'FK' => 'Falkland Islands (Malvinas)',
            'FJ' => 'Fiji the Fiji Islands',
            'FI' => 'Finland',
            'FR' => 'France',
            'GF' => 'French Guiana',
            'PF' => 'French Polynesia',
            'TF' => 'French Southern Territories',
            'GA' => 'Gabon',
            'GM' => 'Gambia the',
            'GE' => 'Georgia',
            'DE' => 'Germany',
            'GH' => 'Ghana',
            'GI' => 'Gibraltar',
            'GR' => 'Greece',
            'GL' => 'Greenland',
            'GD' => 'Grenada',
            'GP' => 'Guadeloupe',
            'GU' => 'Guam',
            'GT' => 'Guatemala',
            'GG' => 'Guernsey',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bissau',
            'GY' => 'Guyana',
            'HT' => 'Haiti',
            'HM' => 'Heard Island and McDonald Islands',
            'VA' => 'Holy See (Vatican City State)',
            'HN' => 'Honduras',
            'HK' => 'Hong Kong',
            'HU' => 'Hungary',
            'IS' => 'Iceland',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'IE' => 'Ireland',
            'IM' => 'Isle of Man',
            'IL' => 'Israel',
            'IT' => 'Italy',
            'JM' => 'Jamaica',
            'JP' => 'Japan',
            'JE' => 'Jersey',
            'JO' => 'Jordan',
            'KZ' => 'Kazakhstan',
            'KE' => 'Kenya',
            'KI' => 'Kiribati',
            'KP' => 'Korea',
            'KR' => 'Korea',
            'KW' => 'Kuwait',
            'KG' => 'Kyrgyz Republic',
            'LA' => 'Lao',
            'LV' => 'Latvia',
            'LB' => 'Lebanon',
            'LS' => 'Lesotho',
            'LR' => 'Liberia',
            'LY' => 'Libyan Arab Jamahiriya',
            'LI' => 'Liechtenstein',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MO' => 'Macao',
            'MK' => 'Macedonia',
            'MG' => 'Madagascar',
            'MW' => 'Malawi',
            'MY' => 'Malaysia',
            'MV' => 'Maldives',
            'ML' => 'Mali',
            'MT' => 'Malta',
            'MH' => 'Marshall Islands',
            'MQ' => 'Martinique',
            'MR' => 'Mauritania',
            'MU' => 'Mauritius',
            'YT' => 'Mayotte',
            'MX' => 'Mexico',
            'FM' => 'Micronesia',
            'MD' => 'Moldova',
            'MC' => 'Monaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MS' => 'Montserrat',
            'MA' => 'Morocco',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'AN' => 'Netherlands Antilles',
            'NL' => 'Netherlands',
            'NC' => 'New Caledonia',
            'NZ' => 'New Zealand',
            'NI' => 'Nicaragua',
            'NE' => 'Niger',
            'NG' => 'Nigeria',
            'NU' => 'Niue',
            'NF' => 'Norfolk Island',
            'MP' => 'Northern Mariana Islands',
            'NO' => 'Norway',
            'OM' => 'Oman',
            'PK' => 'Pakistan',
            'PW' => 'Palau',
            'PS' => 'Palestinian Territory',
            'PA' => 'Panama',
            'PG' => 'Papua New Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Peru',
            'PH' => 'Philippines',
            'PN' => 'Pitcairn Islands',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'PR' => 'Puerto Rico',
            'QA' => 'Qatar',
            'RE' => 'Reunion',
            'RO' => 'Romania',
            'RU' => 'Russian Federation',
            'RW' => 'Rwanda',
            'BL' => 'Saint Barthelemy',
            'SH' => 'Saint Helena',
            'KN' => 'Saint Kitts and Nevis',
            'LC' => 'Saint Lucia',
            'MF' => 'Saint Martin',
            'PM' => 'Saint Pierre and Miquelon',
            'VC' => 'Saint Vincent and the Grenadines',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Sao Tome and Principe',
            'SA' => 'Saudi Arabia',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leone',
            'SG' => 'Singapore',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'SB' => 'Solomon Islands',
            'SO' => 'Somalia, Somali Republic',
            'ZA' => 'South Africa',
            'GS' => 'South Georgia and the South Sandwich Islands',
            'ES' => 'Spain',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudan',
            'SR' => 'Suriname',
            'SJ' => 'Svalbard & Jan Mayen Islands',
            'SZ' => 'Swaziland',
            'SE' => 'Sweden',
            'CH' => 'Switzerland',
            'SY' => 'Syrian Arab Republic',
            'TW' => 'Taiwan',
            'TJ' => 'Tajikistan',
            'TZ' => 'Tanzania',
            'TH' => 'Thailand',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TK' => 'Tokelau',
            'TO' => 'Tonga',
            'TT' => 'Trinidad and Tobago',
            'TN' => 'Tunisia',
            'TR' => 'Turkey',
            'TM' => 'Turkmenistan',
            'TC' => 'Turks and Caicos Islands',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ukraine',
            'AE' => 'United Arab Emirates',
            'GB' => 'United Kingdom',
            'US' => 'United States of America',
            'UM' => 'United States Minor Outlying Islands',
            'VI' => 'United States Virgin Islands',
            'UY' => 'Uruguay, Eastern Republic of',
            'UZ' => 'Uzbekistan',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'WF' => 'Wallis and Futuna',
            'EH' => 'Western Sahara',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabwe'
        );
    }

    public static function calculatePercentage($oldFigure, $newFigure, $deci = false)
    {

        if ($oldFigure != 0 && $newFigure != 0) {
            $percentChange = (1 - $oldFigure / $newFigure) * 100;
        } else {
            $percentChange = 100;
        }

        $val = ($percentChange * 100) / 100;

        if (!$deci) {
            return floor($val);
        }

        return round($val, $deci);
    }

    public static function calcXPercOfY($x, $y, $deci = 2) {

        return round(($x / 100) * $y, 2);
    }

    public static function calculatePercentageNeg($oldFigure, $newFigure, $deci = false)
    {

        if ($newFigure == 0) {
            $newFigure = 1;
        }

        if ($oldFigure != 0 && $newFigure != 0) {
            $percentChange = (1 - $oldFigure / $newFigure) * 100;
        }

        $val = ($percentChange * 100) / 100;

        if (!$deci) {
            return floor($val);
        }

        return round($val, $deci);
    }

    public static function calculatePercentageRound($oldFigure, $newFigure)
    {


        if ($oldFigure != 0 && $newFigure != 0) {
            $percentChange = (1 - $oldFigure / $newFigure) * 100;
        } else {
            $percentChange = 100;
        }
        return round(($percentChange * 100) / 100, 2);
    }

    public static function arrayKeyNotExistsReturnDefault($array, $key, $default = null)
    {

        if (array_key_exists($key, $array))
            return $array[$key];

        return $default;
    }

    public static function csvStringToArray($string, $del = ',')
    {

        $lines = explode(PHP_EOL, $string);

        if (empty($lines[0]))
            return false;

        $keys = array_values(explode($del, str_replace('"', null, $lines[0])));


        $array = [];
        foreach ($lines as $line) {

            $values = str_getcsv($line, $del);

            if (count($keys) != count($values)) {

                continue;
            }

            $array[] = array_combine($keys, $values);
        }

        return $array;
    }

    public static function textFileToArray($path)
    {
        $lines = [];
        $fp = fopen($path, 'r');
        while (!feof($fp))
        {
            $line=fgets($fp);

            //process line however you like
            $line=trim($line);

            //add to array
            $lines[]=$line;

        }
        fclose($fp);
        return $lines;
    }

    public static function filenameNormalizeString($str = '')
    {
        $str = strip_tags($str);
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
        $str = strtolower($str);
        $str = html_entity_decode($str, ENT_QUOTES, "utf-8");
        $str = htmlentities($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
        $str = str_replace(' ', '-', $str);
        $str = rawurlencode($str);
        $str = str_replace('%', '-', $str);
        return $str;
    }

    public static function getCurrencyIsoMap() {
        return [
            'EUR' => '978',
            'USD' => '840',
            'GBP' => '826',
            'NOK' => '578',
            'SEK' => '752',
            'DKK' => '208',
            'AUD' => '036',
            'SGD' => '702',
            'CAD' => '124',
            'MYR' => '458',
            'PLN' => '985',
            'CHF' => '756',
            'NZD' => '554',
            'JPY' => '392',
            'ZAR' => '710',
        ];
    }

    public static function currencyToISO($code)
    {

        $currencies = self::getCurrencyIsoMap();

        if (array_key_exists($code, $currencies))
            return $currencies[$code];

        return false;
    }

    public static function currencyISOToCode($iso)
    {
        $currencies = array_flip(self::getCurrencyIsoMap());

        if (array_key_exists($iso, $currencies))
            return $currencies[$iso];

        return false;
    }

    public static function array2csv($array, $delimiter = ";")
    {
        $buffer = fopen('php://temp', 'r+');

        $i = 0;
        foreach ($array as $elem) {

            if ($i == 0) {
                fputcsv($buffer, array_keys($elem), $delimiter);
            }

            fputcsv($buffer, array_values($elem), $delimiter);

            $i++;
        }

        rewind($buffer);

        $csv = stream_get_contents($buffer);

        fclose($buffer);

        return $csv;
    }

    public static function getPreferredLocale($browserLocale, $countryCode, $default = 'en_GB') {

        $allLocale = self::getAllLocale();

        if (in_array($browserLocale, $allLocale))
            return $browserLocale; // Return found

        $allForCountry = self::getLocalesForCountryCode($countryCode);

        if (!$allForCountry)
            return $default; // Return backup default

        return $allForCountry[0]; // Return default for country
    }

    public static function getQuarter(\DateTime $dateTime) {

        $month = $dateTime->format('n');
        return ceil($month / 3);
    }

    static public function getVATCharged($vatRate, $gross) {

        if ($vatRate == 0)
            return 0;

        $vatDivisor = 1 + ($vatRate / 100);

        $priceBeforeVat = $gross / $vatDivisor;

        return round($gross - $priceBeforeVat, 2);
    }

    static public function formatInterval(\DateInterval $interval) {

        $result = "";
        if ($interval->y) { $result .= $interval->format("%y years "); }
        if ($interval->m) { $result .= $interval->format("%m months "); }
        if ($interval->d) { $result .= $interval->format("%d days "); }
        if ($interval->h) { $result .= $interval->format("%h hours "); }
        if ($interval->i) { $result .= $interval->format("%i minutes "); }
        if ($interval->s) { $result .= $interval->format("%s seconds "); }

        return $result;
    }

    static public function formatSecondsToHours($seconds) {

        if (!is_numeric($seconds))
            return '';

        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds / 60) % 60);
        $seconds = $seconds % 60;

        $output = '';

        if ($hours != 0) {
            $output .= $hours .'h ';
        }
        if ($minutes != 0) {
            $output .= $minutes .'m ';
        }
        $output .= $seconds .'s';

        return $output;
    }

    static public function sortArrayLargestValue(&$array, $key) {

        return usort($array, function ($item1, $item2) use ($key) {
            return $item2[$key] <=> $item1[$key];
        });
    }

    static public function pickElementsWithLargestValue($array, $key, $pickCount) {

        usort($array, function ($item1, $item2) use ($key) {
            return $item2[$key] <=> $item1[$key];
        });

        $res = [];

        for ($i = 0; $i<$pickCount; $i++) {

            if (array_key_exists($i, $array)) {
                $res[] = $array[$i];
            }
        }

        return $res;
    }

    static public function getMonthsBetween($datetime1, $datetime2) {

        $months = $datetime1->diff($datetime2);
        return (($months->y) * 12) + ($months->m);
    }

    static public function getDaysBetween($later, $earlier) {

        return $later->diff($earlier)->format("%r%a");
    }

    static public function generateApiKey() {

        return strtoupper(md5(random_bytes(50)));
    }


    static public function base64_url_encode($input) {
        return strtr(base64_encode($input), '+/=', '._-');
    }

    static public function base64_url_decode($input) {
        return base64_decode(strtr($input, '._-', '+/='));
    }

    static public function isJson($string) {
        \json_decode($string);
        return \json_last_error() === JSON_ERROR_NONE;
    }


    static public function countryCodeToContinent($countryCode) {


        /*
         * Map a two-letter continent code onto the name of the continent.
         */
        $continents = [
            "AS" => "Asia",
            "AN" => "Antarctica",
            "AF" => "Africa",
            "SA" => "South America",
            "EU" => "Europe",
            "OC" => "Oceania",
            "NA" => "North America"
        ];

        /*
         * Map a two-letter country code onto the country's two-letter continent code.
         */
        $country_continents = [
            "AF" => "AS",
            "AX" => "EU",
            "AL" => "EU",
            "DZ" => "AF",
            "AS" => "OC",
            "AD" => "EU",
            "AO" => "AF",
            "AI" => "NA",
            "AQ" => "AN",
            "AG" => "NA",
            "AR" => "SA",
            "AM" => "AS",
            "AW" => "NA",
            "AU" => "OC",
            "AT" => "EU",
            "AZ" => "AS",
            "BS" => "NA",
            "BH" => "AS",
            "BD" => "AS",
            "BB" => "NA",
            "BY" => "EU",
            "BE" => "EU",
            "BZ" => "NA",
            "BJ" => "AF",
            "BM" => "NA",
            "BT" => "AS",
            "BO" => "SA",
            "BA" => "EU",
            "BW" => "AF",
            "BV" => "AN",
            "BR" => "SA",
            "IO" => "AS",
            "BN" => "AS",
            "BG" => "EU",
            "BF" => "AF",
            "BI" => "AF",
            "KH" => "AS",
            "CM" => "AF",
            "CA" => "NA",
            "CV" => "AF",
            "KY" => "NA",
            "CF" => "AF",
            "TD" => "AF",
            "CL" => "SA",
            "CN" => "AS",
            "CX" => "AS",
            "CC" => "AS",
            "CO" => "SA",
            "KM" => "AF",
            "CD" => "AF",
            "CG" => "AF",
            "CK" => "OC",
            "CR" => "NA",
            "CI" => "AF",
            "HR" => "EU",
            "CU" => "NA",
            "CY" => "AS",
            "CZ" => "EU",
            "DK" => "EU",
            "DJ" => "AF",
            "DM" => "NA",
            "DO" => "NA",
            "EC" => "SA",
            "EG" => "AF",
            "SV" => "NA",
            "GQ" => "AF",
            "ER" => "AF",
            "EE" => "EU",
            "ET" => "AF",
            "FO" => "EU",
            "FK" => "SA",
            "FJ" => "OC",
            "FI" => "EU",
            "FR" => "EU",
            "GF" => "SA",
            "PF" => "OC",
            "TF" => "AN",
            "GA" => "AF",
            "GM" => "AF",
            "GE" => "AS",
            "DE" => "EU",
            "GH" => "AF",
            "GI" => "EU",
            "GR" => "EU",
            "GL" => "NA",
            "GD" => "NA",
            "GP" => "NA",
            "GU" => "OC",
            "GT" => "NA",
            "GG" => "EU",
            "GN" => "AF",
            "GW" => "AF",
            "GY" => "SA",
            "HT" => "NA",
            "HM" => "AN",
            "VA" => "EU",
            "HN" => "NA",
            "HK" => "AS",
            "HU" => "EU",
            "IS" => "EU",
            "IN" => "AS",
            "ID" => "AS",
            "IR" => "AS",
            "IQ" => "AS",
            "IE" => "EU",
            "IM" => "EU",
            "IL" => "AS",
            "IT" => "EU",
            "JM" => "NA",
            "JP" => "AS",
            "JE" => "EU",
            "JO" => "AS",
            "KZ" => "AS",
            "KE" => "AF",
            "KI" => "OC",
            "KP" => "AS",
            "KR" => "AS",
            "KW" => "AS",
            "KG" => "AS",
            "LA" => "AS",
            "LV" => "EU",
            "LB" => "AS",
            "LS" => "AF",
            "LR" => "AF",
            "LY" => "AF",
            "LI" => "EU",
            "LT" => "EU",
            "LU" => "EU",
            "MO" => "AS",
            "MK" => "EU",
            "MG" => "AF",
            "MW" => "AF",
            "MY" => "AS",
            "MV" => "AS",
            "ML" => "AF",
            "MT" => "EU",
            "MH" => "OC",
            "MQ" => "NA",
            "MR" => "AF",
            "MU" => "AF",
            "YT" => "AF",
            "MX" => "NA",
            "FM" => "OC",
            "MD" => "EU",
            "MC" => "EU",
            "MN" => "AS",
            "ME" => "EU",
            "MS" => "NA",
            "MA" => "AF",
            "MZ" => "AF",
            "MM" => "AS",
            "NA" => "AF",
            "NR" => "OC",
            "NP" => "AS",
            "AN" => "NA",
            "NL" => "EU",
            "NC" => "OC",
            "NZ" => "OC",
            "NI" => "NA",
            "NE" => "AF",
            "NG" => "AF",
            "NU" => "OC",
            "NF" => "OC",
            "MP" => "OC",
            "NO" => "EU",
            "OM" => "AS",
            "PK" => "AS",
            "PW" => "OC",
            "PS" => "AS",
            "PA" => "NA",
            "PG" => "OC",
            "PY" => "SA",
            "PE" => "SA",
            "PH" => "AS",
            "PN" => "OC",
            "PL" => "EU",
            "PT" => "EU",
            "PR" => "NA",
            "QA" => "AS",
            "RE" => "AF",
            "RO" => "EU",
            "RU" => "EU",
            "RW" => "AF",
            "SH" => "AF",
            "KN" => "NA",
            "LC" => "NA",
            "PM" => "NA",
            "VC" => "NA",
            "WS" => "OC",
            "SM" => "EU",
            "ST" => "AF",
            "SA" => "AS",
            "SN" => "AF",
            "RS" => "EU",
            "SC" => "AF",
            "SL" => "AF",
            "SG" => "AS",
            "SK" => "EU",
            "SI" => "EU",
            "SB" => "OC",
            "SO" => "AF",
            "ZA" => "AF",
            "GS" => "AN",
            "ES" => "EU",
            "LK" => "AS",
            "SD" => "AF",
            "SR" => "SA",
            "SJ" => "EU",
            "SZ" => "AF",
            "SE" => "EU",
            "CH" => "EU",
            "SY" => "AS",
            "TW" => "AS",
            "TJ" => "AS",
            "TZ" => "AF",
            "TH" => "AS",
            "TL" => "AS",
            "TG" => "AF",
            "TK" => "OC",
            "TO" => "OC",
            "TT" => "NA",
            "TN" => "AF",
            "TR" => "AS",
            "TM" => "AS",
            "TC" => "NA",
            "TV" => "OC",
            "UG" => "AF",
            "UA" => "EU",
            "AE" => "AS",
            "GB" => "EU",
            "UM" => "OC",
            "US" => "NA",
            "UY" => "SA",
            "UZ" => "AS",
            "VU" => "OC",
            "VE" => "SA",
            "VN" => "AS",
            "VG" => "NA",
            "VI" => "NA",
            "WF" => "OC",
            "EH" => "AF",
            "YE" => "AS",
            "ZM" => "AF",
            "ZW" => "AF"
        ];

        return $continents[$country_continents[$countryCode]];
    }

    static function langCountryList()
    {
        return ['af-ZA',
            'am-ET',
            'ar-AE',
            'ar-BH',
            'ar-DZ',
            'ar-EG',
            'ar-IQ',
            'ar-JO',
            'ar-KW',
            'ar-LB',
            'ar-LY',
            'ar-MA',
            'arn-CL',
            'ar-OM',
            'ar-QA',
            'ar-SA',
            'ar-SY',
            'ar-TN',
            'ar-YE',
            'as-IN',
            'az-Cyrl-AZ',
            'az-Latn-AZ',
            'ba-RU',
            'be-BY',
            'bg-BG',
            'bn-BD',
            'bn-IN',
            'bo-CN',
            'br-FR',
            'bs-Cyrl-BA',
            'bs-Latn-BA',
            'ca-ES',
            'co-FR',
            'cs-CZ',
            'cy-GB',
            'da-DK',
            'de-AT',
            'de-CH',
            'de-DE',
            'de-LI',
            'de-LU',
            'dsb-DE',
            'dv-MV',
            'el-GR',
            'en-029',
            'en-AU',
            'en-BZ',
            'en-CA',
            'en-GB',
            'en-IE',
            'en-IN',
            'en-JM',
            'en-MY',
            'en-NZ',
            'en-PH',
            'en-SG',
            'en-TT',
            'en-US',
            'en-ZA',
            'en-ZW',
            'es-AR',
            'es-BO',
            'es-CL',
            'es-CO',
            'es-CR',
            'es-DO',
            'es-EC',
            'es-ES',
            'es-GT',
            'es-HN',
            'es-MX',
            'es-NI',
            'es-PA',
            'es-PE',
            'es-PR',
            'es-PY',
            'es-SV',
            'es-US',
            'es-UY',
            'es-VE',
            'et-EE',
            'eu-ES',
            'fa-IR',
            'fi-FI',
            'fil-PH',
            'fo-FO',
            'fr-BE',
            'fr-CA',
            'fr-CH',
            'fr-FR',
            'fr-LU',
            'fr-MC',
            'fy-NL',
            'ga-IE',
            'gd-GB',
            'gl-ES',
            'gsw-FR',
            'gu-IN',
            'ha-Latn-NG',
            'he-IL',
            'hi-IN',
            'hr-BA',
            'hr-HR',
            'hsb-DE',
            'hu-HU',
            'hy-AM',
            'id-ID',
            'ig-NG',
            'ii-CN',
            'is-IS',
            'it-CH',
            'it-IT',
            'iu-Cans-CA',
            'iu-Latn-CA',
            'ja-JP',
            'ka-GE',
            'kk-KZ',
            'kl-GL',
            'km-KH',
            'kn-IN',
            'kok-IN',
            'ko-KR',
            'ky-KG',
            'lb-LU',
            'lo-LA',
            'lt-LT',
            'lv-LV',
            'mi-NZ',
            'mk-MK',
            'ml-IN',
            'mn-MN',
            'mn-Mong-CN',
            'moh-CA',
            'mr-IN',
            'ms-BN',
            'ms-MY',
            'mt-MT',
            'nb-NO',
            'ne-NP',
            'nl-BE',
            'nl-NL',
            'nn-NO',
            'nso-ZA',
            'oc-FR',
            'or-IN',
            'pa-IN',
            'pl-PL',
            'prs-AF',
            'ps-AF',
            'pt-BR',
            'pt-PT',
            'qut-GT',
            'quz-BO',
            'quz-EC',
            'quz-PE',
            'rm-CH',
            'ro-RO',
            'ru-RU',
            'rw-RW',
            'sah-RU',
            'sa-IN',
            'se-FI',
            'se-NO',
            'se-SE',
            'si-LK',
            'sk-SK',
            'sl-SI',
            'sma-NO',
            'sma-SE',
            'smj-NO',
            'smj-SE',
            'smn-FI',
            'sms-FI',
            'sq-AL',
            'sr-Cyrl-BA',
            'sr-Cyrl-CS',
            'sr-Cyrl-ME',
            'sr-Cyrl-RS',
            'sr-Latn-BA',
            'sr-Latn-CS',
            'sr-Latn-ME',
            'sr-Latn-RS',
            'sv-FI',
            'sv-SE',
            'sw-KE',
            'syr-SY',
            'ta-IN',
            'te-IN',
            'tg-Cyrl-TJ',
            'th-TH',
            'tk-TM',
            'tn-ZA',
            'tr-TR',
            'tt-RU',
            'tzm-Latn-DZ',
            'ug-CN',
            'uk-UA',
            'ur-PK',
            'uz-Cyrl-UZ',
            'uz-Latn-UZ',
            'vi-VN',
            'wo-SN',
            'xh-ZA',
            'yo-NG',
            'zh-CN',
            'zh-HK',
            'zh-MO',
            'zh-SG',
            'zh-TW',
            'zu-ZA'
        ];
    }

    static function getAllLocale() {

        $locales = self::langCountryList();

        $found = [];

        foreach ($locales as $locale)
        {
            $locale_region = \locale_get_region($locale);
            $locale_language = \locale_get_primary_language($locale);
            $locale_array = ['language' => $locale_language,
                'region' => $locale_region];

            $found[] = \locale_compose($locale_array);
        }

        return $found;
    }

    /**
     * @param $country_code
     * @param string $language_code
     * @return array|null
     */
    static function getLocalesForCountryCode($country_code, $language_code = '')
    {
        // Locale list taken from:
        // http://stackoverflow.com/questions/3191664/
        // list-of-all-locales-and-their-short-codes

        $locales = self::langCountryList();

        $found = [];

        foreach ($locales as $locale)
        {
            $locale_region = \locale_get_region($locale);
            $locale_language = \locale_get_primary_language($locale);
            $locale_array = ['language' => $locale_language,
                'region' => $locale_region];

            if (strtoupper($country_code) == $locale_region &&
                $language_code == '')
            {
                $found[] = \locale_compose($locale_array);
            }
            elseif (strtoupper($country_code) == $locale_region &&
                strtolower($language_code) == $locale_language)
            {
                $found[] = \locale_compose($locale_array);
            }
        }

        if (empty($found))
            return null;

        return $found;
    }


    public static function formatCurrency($value, $currency, $intLocale, $stripDeci = false) {

        $number = new \NumberFormatter($intLocale, \NumberFormatter::CURRENCY);

        $price = $number->formatCurrency($value, $currency);

        if ($stripDeci) {

            $deciSep = ',';

            if (strpos($price, ".") !== false) {
                $deciSep = '.';
            }

            $parts = explode($deciSep, $price);

            return trim($parts[0]);
        }

        return trim($price);
    }

    public static function formatCurrencyHtml($value, $currency, $intLocale, $stripDeci = false) {

        $number = new \NumberFormatter($intLocale, \NumberFormatter::CURRENCY);

        $price = trim($number->formatCurrency($value, $currency));

        return Common::priceWrapHtml($price, $stripDeci);
    }
}