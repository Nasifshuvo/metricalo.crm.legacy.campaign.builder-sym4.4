<?php

namespace App\Bundles\MainBundle\Entity;


class Campaign
{
    public $product;

    public $productName;
    public $locale;
    public $slug;
    public $skillGameItem;
    public $vertical;
    public $contest = true;

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return 'en';
    }

    public function getSlug() {
        echo "";
    }

    public function getSecondaryAdvertisedItemName() {
        return 'Item';
    }

    public function isContest() {
        return $this->contest;
    }
    public function setContest($contest)
    {
        $this->contest = $contest;
    }

    public function getDisplayLocale() {
        return 'en';
    }

    public function hasMultipleLocale() {
        return false;
    }

    public function getVertical() {
        return false;
    }

    public function getSkillGameItemVendorName() {
        return 'Vendor';
    }

    public function isV2Terms() {
        return true;
    }

    /**
     * @return mixed
     */
    public function getSkillGameItem()
    {
        return $this->skillGameItem;
    }

    /**
     * @param mixed $skillGameItem
     * @return $this
     */
    public function setSkillGameItem($skillGameItem): self
    {
        $this->skillGameItem = $skillGameItem;
        return $this;
    }


}