<?php

namespace App\Bundles\MainBundle\Entity;


use App\Bundles\Common\Symfony\Utils\Common;
use App\Bundles\MainBundle\Entity\Product;
use App\Bundles\MainBundle\Entity\Service;
use App\Bundles\MainBundle\Enum\OrderStatusEnum;
use App\Bundles\MainBundle\Enum\OrderTypeEnum;
use App\SubscriptionBundle\Entity\Subscription;
use Doctrine\Common\Collections\ArrayCollection;

class Order extends AbstractOrder
{
    public function __construct()
    {
        $this->attributes = new ArrayCollection();

        $this->setStatus(OrderStatusEnum::UNPAID);
        $this->setType(OrderTypeEnum::TRIAL);
    }

    public function getNProduct() {
        return new Product();
    }

    public function getTotalFormatHtml($stripDeci = false)
    {
        $number = new \NumberFormatter($this->getLead()->getIntlLocale(), \NumberFormatter::CURRENCY);

        $price = $number->formatCurrency($this->getTotal(), $this->getCurrency());

        return Common::priceWrapHtml($price, $stripDeci);
    }

    public function getTotal()
    {
        return 10;
    }

    public function getRefundedOrChargebackAt()
    {
        return new \DateTime();
    }

    public function getVatRate()
    {
        return 20;
    }

    public function getTotalWithoutVat() {

        return 8;
    }


    public function addVariationAsString($attribute)
    {
        $variationText = $this->getVariation();
        if (!empty($this->getVariation())) {
            $variationText .= ' | ';
        }

        $variation = $attribute->getVariation();

        $variationText .= $variation->getName() . ' - ' . $attribute->getName();
        $this->setVariation($variationText);
    }

    public function isTrial()
    {
        if ($this->getType() == OrderTypeEnum::TRIAL) {
            return true;
        }

        return false;
    }

    public function isSubscriptionOrderAndNotTrial()
    {
        if ($this->getType() == OrderTypeEnum::SUBSCRIPTION || $this->getType() == OrderTypeEnum::PAST_DUE) {
            return true;
        }
        return false;
    }

    public function isCancellationFee()
    {
        if ($this->getType() == OrderTypeEnum::CANCELLATION_FEE) {
            return true;
        }
        return false;
    }

    public function isPaidFor()
    {
        if ($this->getStatus() == OrderStatusEnum::COMPLETED ||
        $this->getStatus() == OrderStatusEnum::NEEDS_SHIPPING) {
            return true;
        }
        return false;
    }

    public function shouldSendInvoice()
    {
        return $this->getCampaign()->isSendInvoice();
    }

    public function getPrettyStatus()
    {
        $orderStatus = OrderStatusEnum::toArray();
        return $orderStatus[$this->getStatus()];
    }

    public function getPrettyCurrency() {

        return 'EUR';
    }

    public function isAffiliateOrder() {

        if (!empty($this->getLead()) && !empty($this->getLead()->getAffiliate())) {
            return true;
        }

        return false;
    }


    public function getLead() {
        return new Lead();
    }

    public function getCountryCode() {
        return $this->getCustomer()->getCountryCode();
    }

    public function getService() {

        $service = new Service();

        return $service;
    }

    public function getCampaign() {
        return $this->getLead()->getCampaign();
    }

    public function getCampaignDesign() {
        return $this->getLead()->getCampaignDesign();
    }

    public function isSubscriptionOrder() {
        return true;
    }

    public function isPartOfSubscription() {
        return true;
    }

    /**
     * @VirtualProperty
     * @SerializedName("id")
     */
    public function getOrderID() {
        return $this->getId();
    }

    /**
     * @VirtualProperty
     * @SerializedName("product_name")
     */
    public function getProductName() {

        return $this->getService()->getName();
    }

    /**
     * @VirtualProperty
     * @SerializedName("status")
     */
    public function getOrderStatus() {
        return $this->getStatus();
    }

    /**
     * @VirtualProperty
     * @SerializedName("updated_at")
     */
    public function getOrderUpdatedAt() {
        return $this->getUpdatedAt();
    }

    public function getCompanyRelatedId() {
        return 1;
    }

    /**
     * @VirtualProperty
     * @SerializedName("created_at")
     */
    public function getOrderCreatedAt() {
        return $this->getCreatedAt();
    }

    public function hasVat() {
        return true;
    }

    public function getVatCharged()
    {
        return 2;
    }


    public function getAuthorizedAt()
    {
        return new \DateTime();
    }


    public function getSubscriptionPrice()
    {
        return 10;
    }

    public function getSubscriptionTrialDays()
    {
        return 3;
    }

    public function getSubscriptionIntervalDays()
    {
        return 30;
    }

    public function getPaidIntervalDays()
    {
        return 30;
    }

    public function getCompanyVatNumber()
    {
        $company = new Company();
        return $company->getVATNumber();
    }

    public function __clone() {
        $this->id = null;
    }

    public function __toString() {
        return '#' . $this->getId() . ' - ' . $this->getCustomer()->getFullName();
    }
}