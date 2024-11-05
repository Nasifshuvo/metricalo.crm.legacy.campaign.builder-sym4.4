<?php
/**
 * Created by PhpStorm.
 * * User: Unknown
 * Date: 4/26/16
 * Time: 3:19 PM
 */

namespace App\Bundles\MainBundle\Entity;

abstract class AbstractOrder
{

    public $id;

    public $status;


    protected $serviceRelatedId;

    protected $subscriptionOrderNumber;

    protected $total;

    protected $currency;


    protected $customer;

    protected $product;


    protected $variation;


    protected $attributes;

    protected $subscription;


    protected $type;

    protected $needsShipping = false;

    protected $shipped = false;

    protected $statusMessage;

    protected $transactionID;

    protected $extraIdentifier;

    protected $paymentGateway;

    protected $merchantAccount;

    protected $refundedAt;


    protected $bankRequestedRefund = false;

    protected $chargeBackReceivedAt;

    protected $chargeBackReasonCode = null;

    protected $creditCard;

    protected $lastAttemptedPayment;

    protected $async = false;

    protected $asyncData;

    protected $result;

    protected $rewarded = false;



    protected $gatewayResponseCode;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUniqueIdentifier() {
        return '1234';
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return $this
     */
    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServiceRelatedId()
    {
        return $this->serviceRelatedId;
    }

    /**
     * @param mixed $serviceRelatedId
     * @return $this
     */
    public function setServiceRelatedId($serviceRelatedId): self
    {
        $this->serviceRelatedId = $serviceRelatedId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubscriptionOrderNumber()
    {
        return $this->subscriptionOrderNumber;
    }

    /**
     * @param mixed $subscriptionOrderNumber
     * @return $this
     */
    public function setSubscriptionOrderNumber($subscriptionOrderNumber): self
    {
        $this->subscriptionOrderNumber = $subscriptionOrderNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return 20;
    }

    /**
     * @param mixed $total
     * @return $this
     */
    public function setTotal($total): self
    {
        $this->total = $total;
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
    public function setCurrency($currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     * @return $this
     */
    public function setCustomer($customer): self
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     * @return $this
     */
    public function setProduct($product): self
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVariation()
    {
        return $this->variation;
    }

    /**
     * @param mixed $variation
     * @return $this
     */
    public function setVariation($variation): self
    {
        $this->variation = $variation;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param mixed $attributes
     * @return $this
     */
    public function setAttributes($attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSubscription()
    {
        return $this->subscription;
    }

    /**
     * @param mixed $subscription
     * @return $this
     */
    public function setSubscription($subscription): self
    {
        $this->subscription = $subscription;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     * @return $this
     */
    public function setType($type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return bool
     */
    public function isNeedsShipping(): bool
    {
        return $this->needsShipping;
    }

    /**
     * @param bool $needsShipping
     * @return $this
     */
    public function setNeedsShipping(bool $needsShipping): self
    {
        $this->needsShipping = $needsShipping;
        return $this;
    }

    /**
     * @return bool
     */
    public function isShipped(): bool
    {
        return $this->shipped;
    }

    /**
     * @param bool $shipped
     * @return $this
     */
    public function setShipped(bool $shipped): self
    {
        $this->shipped = $shipped;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * @param mixed $statusMessage
     * @return $this
     */
    public function setStatusMessage($statusMessage): self
    {
        $this->statusMessage = $statusMessage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTransactionID()
    {
        return $this->transactionID;
    }

    /**
     * @param mixed $transactionID
     * @return $this
     */
    public function setTransactionID($transactionID): self
    {
        $this->transactionID = $transactionID;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtraIdentifier()
    {
        return $this->extraIdentifier;
    }

    /**
     * @param mixed $extraIdentifier
     * @return $this
     */
    public function setExtraIdentifier($extraIdentifier): self
    {
        $this->extraIdentifier = $extraIdentifier;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentGateway()
    {
        return $this->paymentGateway;
    }

    /**
     * @param mixed $paymentGateway
     * @return $this
     */
    public function setPaymentGateway($paymentGateway): self
    {
        $this->paymentGateway = $paymentGateway;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantAccount()
    {
        return $this->merchantAccount;
    }

    /**
     * @param mixed $merchantAccount
     * @return $this
     */
    public function setMerchantAccount($merchantAccount): self
    {
        $this->merchantAccount = $merchantAccount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRefundedAt()
    {
        return $this->refundedAt;
    }

    /**
     * @param mixed $refundedAt
     * @return $this
     */
    public function setRefundedAt($refundedAt): self
    {
        $this->refundedAt = $refundedAt;
        return $this;
    }

    /**
     * @return bool
     */
    public function isBankRequestedRefund(): bool
    {
        return $this->bankRequestedRefund;
    }

    /**
     * @param bool $bankRequestedRefund
     * @return $this
     */
    public function setBankRequestedRefund(bool $bankRequestedRefund): self
    {
        $this->bankRequestedRefund = $bankRequestedRefund;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChargeBackReceivedAt()
    {
        return $this->chargeBackReceivedAt;
    }

    /**
     * @param mixed $chargeBackReceivedAt
     * @return $this
     */
    public function setChargeBackReceivedAt($chargeBackReceivedAt): self
    {
        $this->chargeBackReceivedAt = $chargeBackReceivedAt;
        return $this;
    }

    /**
     * @return null
     */
    public function getChargeBackReasonCode()
    {
        return $this->chargeBackReasonCode;
    }

    /**
     * @param null $chargeBackReasonCode
     * @return $this
     */
    public function setChargeBackReasonCode($chargeBackReasonCode): self
    {
        $this->chargeBackReasonCode = $chargeBackReasonCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }

    /**
     * @param mixed $creditCard
     * @return $this
     */
    public function setCreditCard($creditCard): self
    {
        $this->creditCard = $creditCard;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastAttemptedPayment()
    {
        return $this->lastAttemptedPayment;
    }

    /**
     * @param mixed $lastAttemptedPayment
     * @return $this
     */
    public function setLastAttemptedPayment($lastAttemptedPayment): self
    {
        $this->lastAttemptedPayment = $lastAttemptedPayment;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAsync(): bool
    {
        return $this->async;
    }

    /**
     * @param bool $async
     * @return $this
     */
    public function setAsync(bool $async): self
    {
        $this->async = $async;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAsyncData()
    {
        return $this->asyncData;
    }

    /**
     * @param mixed $asyncData
     * @return $this
     */
    public function setAsyncData($asyncData): self
    {
        $this->asyncData = $asyncData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     * @return $this
     */
    public function setResult($result): self
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRewarded(): bool
    {
        return $this->rewarded;
    }

    /**
     * @param bool $rewarded
     * @return $this
     */
    public function setRewarded(bool $rewarded): self
    {
        $this->rewarded = $rewarded;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGatewayResponseCode()
    {
        return $this->gatewayResponseCode;
    }

    /**
     * @param mixed $gatewayResponseCode
     * @return $this
     */
    public function setGatewayResponseCode($gatewayResponseCode): self
    {
        $this->gatewayResponseCode = $gatewayResponseCode;
        return $this;
    }


}
