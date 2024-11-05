<?php

namespace App\Bundles\MainBundle\Entity;

class Lead
{

    public function isDirectMarketingLead()
    {
        return false;
    }

    public function isVerticalClick($flag = true)
    {
        return $flag;
    }

    public function getUserLanguage()
    {
        return 'en';
    }

    public function getIntlLocale()
    {
        return 'en';

        $userLang = $this->getUserLanguage();

        if (empty($userLang) || strlen($userLang) >= 5) {
            return 'en_GB';
        }

        $userLang = str_replace('_', '-', $userLang);

        if (strpos($userLang, '-') === false) {
            // format is just "de" rather then de_DE
            return $userLang . '-' . strtoupper($userLang);
        }

        return $userLang;
    }

    public function getFacebookPixels()
    {
        return null;
    }

    public function getTiktokPixels()
    {
        return null;
    }

    public function getGoogleTagPixels()
    {
        return null;
    }

    public function getTagManagerID()
    {
        return null;
    }

    public function isCounted()
    {
        return false;
    }

    public function getCountryCode()
    {
        return 'GB';
    }

    public function getDynamicSkillGameItemName()
    {
        return 'Test Skill Game Item Name';
    }

    public function getDynamicSkillGameItemImage()
    {
        return 'https://placehold.co/200';
    }

    public function getAffiliate() {
        return new Affiliate();
    }
}