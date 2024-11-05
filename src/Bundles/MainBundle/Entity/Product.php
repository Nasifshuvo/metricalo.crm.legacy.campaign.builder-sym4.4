<?php

namespace App\Bundles\MainBundle\Entity;


class Product
{
    public $name;

    public $description;

    public $subscriptionName;

    public $trialDays;

    public $currency;

    public $price;

    public $subscriptionPrice;

    public function hasTrial() {
        return true;
    }

    public function hasVariations() {
        return false;
    }

    public function getAllBenefits()
    {
        return [
            'website benefit 1',
            'product benefit 1',
            'product benefit 2',
            'product benefit 3',
            'product benefit 4'
        ];
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionName()
    {
        return $this->subscriptionName;
    }

    /**
     * @param mixed $subscriptionName
     * @return $this
     */
    public function setSubscriptionName($subscriptionName)
    {
        $this->subscriptionName = $subscriptionName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTrialDays()
    {
        return $this->trialDays;
    }

    /**
     * @param mixed $trialDays
     * @return $this
     */
    public function setTrialDays($trialDays)
    {
        $this->trialDays = $trialDays;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return 'EUR';
    }

    /**
     * @param mixed $currency
     * @return $this
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return 3;
    }

    /**
     * @param mixed $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionPrice()
    {
        return 30;
    }

    /**
     * @param mixed $subscriptionPrice
     * @return $this
     */
    public function setSubscriptionPrice($subscriptionPrice)
    {
        $this->subscriptionPrice = $subscriptionPrice;
        return $this;
    }

    public function getSubscriptionTrialDays() {
        return '3';
    }
    public function getSubscriptionIntervalDays() {
        return 30;
    }
}