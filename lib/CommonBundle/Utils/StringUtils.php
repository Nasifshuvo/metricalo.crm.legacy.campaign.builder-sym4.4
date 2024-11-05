<?php

declare(strict_types=1);

namespace Common\Utils;

/**
 * @author None
 */
class StringUtils
{
    public static function cutStringIfLongerThen($string, $maxLength = 200)
    {
        if (mb_strlen($string) > $maxLength) {
            return mb_substr($string, 0, $maxLength);
        }

        return $string;
    }

    public static function startsWith($haystack, $needle): bool
    {
        return $needle === '' || mb_strpos($haystack, (string) $needle) === 0;
    }

    public static function endsWith($haystack, $needle): bool
    {
        return $needle === '' || mb_substr($haystack, -mb_strlen($needle)) === $needle;
    }

    public static function removeAccents($str)
    {
        // special accents
        $a = ['�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', '�', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', '?', '?', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', '?', '?', 'L', 'l', 'N', 'n', 'N', 'n', 'N', 'n', '?', 'O', 'o', 'O', 'o', 'O', 'o', '.', '.', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', '.', '.', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', '.', 'Z', 'z', 'Z', 'z', '.', '.', '?', '.', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', '?', '?', '?', '?', '?', '?'];
        $b = ['A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'];

        return str_replace($a, $b, $str);
    }

    public static function zerofill($num, $zerofill = 5): string
    {
        return str_pad($num, $zerofill, '0', \STR_PAD_LEFT);
    }

    public static function num2alpha($n): string
    {
        for ($r = ''; $n >= 0; $n = (int) ($n / 26) - 1) {
            $r = chr($n % 26 + 0x41) . $r;
        }

        return $r;
    }

    /*
     * Convert a string of uppercase letters to an integer.
     */
    public static function alpha2num($a): int
    {
        $l = mb_strlen($a);
        $n = 0;

        for ($i = 0; $i < $l; ++$i) {
            $n = $n * 26 + ord($a[$i]) - 0x40;
        }

        return $n - 1;
    }

    /** @return mixed[] */
    public static function indexNumAlpha($array): array
    {
        $ret = [];

        foreach ($array as $k => $v) {
            $ret[self::num2alpha($k)] = $v;
        }

        return $ret;
    }

    public static function getStringBetween($string, $start, $end): string
    {
        $string = ' ' . $string;
        $ini = mb_strpos($string, (string) $start);

        if ($ini === 0) {
            return '';
        }

        $ini += mb_strlen($start);
        $len = mb_strpos($string, (string) $end, $ini) - $ini;

        return mb_substr($string, $ini, $len);
    }

    public static function getWordFromString($string, $word = 'first')
    {
        $string = trim($string);

        if (mb_strpos($string, ' ') === false) {
            return $word;
        }

        $parts = explode(' ', $string);

        if ($word === 'first') {
            return $parts[0];
        }

        return end($parts);
    }

    public static function stripDomainScheme($domain)
    {
        $domain = str_replace('https://', '', $domain);

        return str_replace('http://', '', $domain);
    }

    public static function stripNonAlphaNumeric($string)
    {
        return preg_replace('/[^A-Za-z0-9 ]/', '', $string);
    }

    public static function snakeCaseToNormalCase($string): string
    {
        // Replace underscores with spaces
        $string = str_replace('_', ' ', $string);

        // Convert to lower case to make sure the capitalization will be uniform
        $string = mb_strtolower($string);

        // Capitalize the first letter of each word
        return ucwords($string);
    }

    public static function trimNormalCaseString($string): string
    {
        return ucfirst(mb_strtolower(trim($string)));
    }

    public static function randomKey($length): string
    {
        $pool = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));

        $key = '';

        for ($i = 0; $i < $length; ++$i) {
            $key .= $pool[random_int(0, count($pool) - 1)];
        }

        return $key;
    }

    public static function safeRandomKey($length): string
    {
        return mb_substr(md5(uniqid((string) mt_rand(), true)), 0, $length);
    }

    public static function randomPassword($length = 8): string
    {
        $length = (int) round($length / 2);
        $bytes = openssl_random_pseudo_bytes($length);

        return bin2hex($bytes);
    }

    public static function split_half($string, $center = 0.4): array
    {
        $length2 = mb_strlen($string) * $center;
        $tmp = explode(' ', $string);
        $index = 0;
        $result = ['', ''];

        foreach ($tmp as $word) {
            if (!$index && mb_strlen($result[0]) > $length2) {
                ++$index;
            }

            $result[$index] .= $word . ' ';
        }

        return $result;
    }

    public static function stripNonAscii($str)
    {
        return preg_replace('/[[:^print:]]/', '', $str);
    }

    public static function addWhitespaceToCamelCase($string)
    {
        return preg_replace('/(?<=[a-z])([A-Z])/', ' $1', $string);
    }

    public static function isEmptyOrNull($value): bool
    {
        return $value === '' || $value === null;
    }

    /**
     * Entity Class table prefix.
     *
     * @param $class
     */
    public static function tn($class): string
    {
        $parts = explode('\\', $class);

        return '`' . \Common\Symfony\Utils\Common::camelCaseToSnakeCase((end($parts))) . '`';
    }

    public static function addGetParametersToUrl(string &$url, $params = []): void
    {
        $urlComponents = parse_url($url);
        $queryPrefix = isset($urlComponents['query']) ? '&' : '?';

        $queryParts = [];

        foreach ($params as $key => $value) {
            $queryParts[] = $key . '=' . urlencode($value);
        }

        $newQueryString = implode('&', $queryParts);
        $url .= $queryPrefix . $newQueryString;
    }
}
