<?php

namespace App\Bundles\MainBundle\Entity;

class Service
{
    public function getLogoImagePath()
    {
        return 'https://grapesjs.com/img/grapesjs-logo.png';
    }

    public function getUniqueIdToken()
    {
        return '1234';
    }

    public function getCheckoutDomainNameWithScheme()
    {
        return 'https://service.com';
    }

    public function getName()
    {
        return 'demo.com';
    }

    public function getDomainNoSchema()
    {
        return 'demo.com';
    }

    public function getCompanyName()
    {
        return 'Demo Ltd';
    }

    public function getCompanyAddress()
    {
        return 'A Street, at some place';
    }

    public function getCompanyCity()
    {
        return 'London';
    }

    public function getCompanyPostcode()
    {
        return '1234';
    }

    public function getCompanyCountry()
    {
        return 'Netherlands';
    }

    public function getBusinessNumber()
    {
        return '12345678';
    }

    public function getFaviconUrl()
    {
        return 'https://google.com';
    }

    public function getCampaignDomain()
    {
        return 'go.website.com';
    }

    public function getGoogleAnalyticsCode()
    {
        return null;
    }

    public function getSupportEmail()
    {
        return 'support@websiute.com';
    }

    public function getSupportPhone()
    {
        return '+8526547852';
    }

    public function getDefaultSignUpCampaign()
    {
        return new Campaign();
    }

    public function getUnsubscribeUrl()
    {
        return 'https://google.com';
    }

    public function getTermsAndConditionsUrl()
    {
        return 'https://google.com';
    }

    public function getPrivacyPolicyUrl() {
        return 'https://google.com';

    }

    public function getVatNumber()
    {
        return 'EU12345';
    }
}