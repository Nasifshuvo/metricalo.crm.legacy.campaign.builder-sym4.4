<?php
/**
 * Created by PhpStorm.
 * * User: Unknown
 * Date: 1/15/16
 * Time: 2:19 AM
 */

namespace App\Bundles\MainBundle\Entity;

use App\CampaignBundle\Entity\Customer;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Kf\KitBundle\Doctrine\ORM\Traits as KFT;


/**
 * Credit Card
 *
 * @ORM\Table()
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class CreditCard
{
    public $id;

    /**
     * @ORM\Column(name="cardholder_name", type="string", length=255, nullable=true)
     */
    protected $cardholderName;

    /**
     * @ORM\ManyToOne(targetEntity="\app_customer", inversedBy="creditCards", cascade={"persist"})
     * @ORM\JoinColumn(name="customer_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $customer;

    protected $number;

    /**
     * @ORM\Column(name="brand", type="string", length=255, nullable=true)
     */
    protected $brand;

    /**
     * @ORM\Column(name="hash_identifier", type="string", length=512, nullable=true)
     */
    protected $hashIdentifier;

    /**
     * @ORM\Column(name="masked_number", type="string", length=255, nullable=true)
     */
    protected $maskedNumber;

    protected $rawNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="bin", type="string", nullable=true)
     */
    protected $bin;

    /**
     * @var integer
     *
     * @ORM\Column(name="last4", type="string", nullable=true)
     */
    protected $last4;


    /**
     * @var array
     *
     * @ORM\Column(name="bin_data", type="json_array", nullable=true)
     */
    protected $binData;

    /**
     * @var integer
     *
     * @ORM\Column(name="expiration_month", type="string", nullable=true)
     * @Assert\NotBlank(message="Expiration month cannot be blank.")
     */
    protected $expirationMonth;

    /**
     * @var integer
     *
     * @ORM\Column(name="expiration_year", type="string", nullable=true)
     * @Assert\NotBlank(message="Expiration year cannot be blank.")
     */
    protected $expirationYear;

    protected $cvc;

    /**
     * @ORM\Column(name="gateway_token", type="string", length=1000, nullable=true)
     */
    protected $gatewayToken;

    /**
     * @var integer
     *
     * @ORM\Column(name="initial_purchase_rejection_count", type="integer", options={"default": 0})
     */
    protected $initialPurchaseRejectionCount = 0;

    /**
     * @ORM\Column(name="last_rejected_at", type="datetime", nullable=true)
     */
    protected $lastRejectedAt;

    /**
     * @ORM\ManyToOne(targetEntity="\app_merchant_account", inversedBy="creditCards", cascade={"persist"})
     * @ORM\JoinColumn(name="merchant_account_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $merchantAccount;

    /**
     * @ORM\Column(name="extra_data", type="text", nullable=true)
     */
    protected $extraData;

    /**
     * @ORM\Column(name="prepaid", type="boolean")
     */
    protected $prepaid = false;

    /**
     * @return mixed
     */
    public function getCardholderName()
    {
        return $this->cardholderName;
    }

    /**
     * @param $cardholderName
     * @return $this
     */
    public function setCardholderName($cardholderName)
    {
        $this->cardholderName = $cardholderName;
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
     * @param $customer
     * @return $this
     */
    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRawNumber()
    {
        return $this->rawNumber;
    }

    /**
     * @param $rawNumber
     * @return $this
     */
    public function setRawNumber($rawNumber)
    {
        $this->number = $rawNumber;
        $this->rawNumber = $rawNumber;
        $this->brand = $this->determineCardBrand($rawNumber);
        $this->maskedNumber = substr_replace($rawNumber, str_repeat("X", 12), 0, 12);
        $this->bin = substr($rawNumber, 0, 6);
        $this->last4 = substr($rawNumber, -4);

        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getNumber()
    {
        if ($this->rawNumber)
            return $this->rawNumber;

        return $this->number;
    }

    public function deleteNumber() {
        $this->number = NULL;
    }

    public function getFullyMaskedNumber() {
       return substr_replace($this->maskedNumber, str_repeat("X", 12), 0, 12);
    }

    /**
     * @return mixed
     */
    public function getMaskedNumber()
    {
        return $this->maskedNumber;
    }

    /**
     * @param $maskedNumber
     * @return $this
     */
    public function setMaskedNumber($maskedNumber)
    {
        $this->maskedNumber = $maskedNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpirationMonth()
    {
        return str_pad($this->expirationMonth, 2, '0', STR_PAD_LEFT);
    }

    /**
     * @param $expirationMonth
     * @return $this
     */
    public function setExpirationMonth($expirationMonth)
    {
        $this->expirationMonth = $expirationMonth;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    /**
     * @param $expirationYear
     * @return $this
     */
    public function setExpirationYear($expirationYear)
    {
        $this->expirationYear = $expirationYear;
        return $this;
    }

    /**
     * @return int
     */
    public function getCvc()
    {
        if ($this->cvc === null)
            return null;

        return str_pad($this->cvc, 3, '0', STR_PAD_LEFT);
    }

    /**
     * @param $cvc
     * @return $this
     */
    public function setCvc($cvc)
    {
        $this->cvc = $cvc;
        return $this;
    }

    /**
     * @return int
     */
    public function getBin()
    {
        return $this->bin;
    }

    /**
     * @param int $bin
     * @return $this
     */
    public function setBin($bin)
    {
        $this->bin = $bin;
        return $this;
    }

    /**
     * @return int
     */
    public function getLast4()
    {
        return $this->last4;
    }

    /**
     * @param int $last4
     * @return $this
     */
    public function setLast4($last4)
    {
        $this->last4 = $last4;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHashIdentifier()
    {
        return $this->hashIdentifier;
    }

    /**
     * @param $hashIdentifier
     * @return $this
     */
    public function setHashIdentifier($hashIdentifier)
    {
        $this->hashIdentifier = $hashIdentifier;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGatewayToken()
    {
        return $this->gatewayToken;
    }

    /**
     * @param $gatewayToken
     * @return $this
     */
    public function setGatewayToken($gatewayToken)
    {
        $this->gatewayToken = $gatewayToken;
        return $this;
    }

    /**
     * @return int
     */
    public function getInitialPurchaseRejectionCount()
    {
        return $this->initialPurchaseRejectionCount;
    }

    /**
     * @param $initialPurchaseRejectionCount
     * @return $this
     */
    public function setInitialPurchaseRejectionCount($initialPurchaseRejectionCount)
    {
        $this->initialPurchaseRejectionCount = $initialPurchaseRejectionCount;
        return $this;
    }

    public function incrementInitialPurchaseRejectionCount()
    {
        $this->initialPurchaseRejectionCount = $this->initialPurchaseRejectionCount + 1;
    }

    /**
     * @return mixed
     */
    public function getLastRejectedAt()
    {
        return $this->lastRejectedAt;
    }

    /**
     * @param $lastRejectedAt
     * @return $this
     */
    public function setLastRejectedAt($lastRejectedAt)
    {
        $this->lastRejectedAt = $lastRejectedAt;
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
     * @param $merchantAccount
     * @return $this
     */
    public function setMerchantAccount($merchantAccount)
    {
        $this->merchantAccount = $merchantAccount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param $brand
     * @return $this
     */
    private function setBrand($brand)
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtraData()
    {
        return $this->extraData;
    }

    /**
     * @param mixed $extraData
     * @return $this
     */
    public function setExtraData($extraData)
    {
        $this->extraData = $extraData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function isPrepaid()
    {
        return $this->prepaid;
    }

    /**
     * @param mixed $prepaid
     * @return $this
     */
    public function setPrepaid($prepaid)
    {
        $this->prepaid = $prepaid;
        return $this;
    }

    /**
     * @return array
     */
    public function getBinData()
    {
        return $this->binData;
    }

    /**
     * @param array $binData
     * @return $this
     */
    public function setBinData($binData)
    {
        if (array_key_exists('prepaid', $binData)) {
            $this->prepaid = $binData['prepaid'];
        }

        $this->binData = $binData;
        return $this;
    }

    private function determineCardBrandBin($pan)
    {
        //maximum length is not fixed now, there are growing number of CCs has more numbers in length, limiting can give false negatives atm

        //these regexps accept not whole cc numbers too
        //visa
        $visa_regex = "/^4[0-9]{0,}$/";
        $vpreca_regex = "/^428485[0-9]{0,}$/";
        $postepay_regex = "/^(402360|402361|403035|417631|529948){0,}$/";
        $cartasi_regex = "/^(432917|432930|453998)[0-9]{0,}$/";
        $entropay_regex = "/^(406742|410162|431380|459061|533844|522093)[0-9]{0,}$/";
        $o2money_regex = "/^(422793|475743)[0-9]{0,}$/";

        // MasterCard
        $mastercard_regex = "/^(5[1-5]|222[1-9]|22[3-9]|2[3-6]|27[01]|2720)[0-9]{0,}$/";
        $maestro_regex = "/^(5[06789]|6)[0-9]{0,}$/";
        $kukuruza_regex = "/^525477[0-9]{0,}$/";
        $yunacard_regex = "/^541275[0-9]{0,}$/";

        // American Express
        $amex_regex = "/^3[47][0-9]{0,}$/";

        // Diners Club
        $diners_regex = "/^3(?:0[0-59]{1}|[689])[0-9]{0,}$/";

        //Discover
        $discover_regex = "/^(6011|65|64[4-9]|62212[6-9]|6221[3-9]|622[2-8]|6229[01]|62292[0-5])[0-9]{0,}$/";

        //JCB
        $jcb_regex = "/^(?:2131|1800|35)[0-9]{0,}$/";

        //ordering matter in detection, otherwise can give false results in rare cases
        if (preg_match($jcb_regex, $pan)) {
            return "JCB";
        }

        if (preg_match($amex_regex, $pan)) {
            return "AMEX";
        }

        if (preg_match($diners_regex, $pan)) {
            return "DINERS";
        }

        if (preg_match($visa_regex, $pan)) {
            return "VISA";
        }

        if (preg_match($mastercard_regex, $pan)) {
            return "MASTER";
        }

        if (preg_match($discover_regex, $pan)) {
            return "DISCOVER";
        }

        if (preg_match($maestro_regex, $pan)) {
            if ($pan[0] == '5') {//started 5 must be mastercard
                return "MASTER";
            } else {
                return "MAESTRO"; //maestro is all 60-69 which is not something else, thats why this condition in the end
            }
        }

        return "UNKNOWN"; //unknown for this system
    }

    public function determineCardBrand($pan) {

        $card_pattern = [
            'VISA' => '/^4[0-9]{12}([0-9]{3})?$/',
            'MASTER' => '/^5[1-5][0-9]{14}$/',
            'AMEX' => '/^3[47][0-9]{13}$/',
            'DINERS' => '/^3(0[0-5]|[68][0-9])[0-9]{11}$/',
            'DISCOVER' => '/^6011[0-9]{12}$/',
            'JCB' => '/^(3[0-9]{4}|2131|1800)[0-9]{11}$/',
            'MAESTRO' => '/^(5[06-8]|6)[0-9]{10,17}$/'
        ];

        $thisType = 'UNKNOWN';
        foreach ($card_pattern as $type => $pattern) {
            if (preg_match($pattern, $pan)) {
                $thisType = $type;
                break;
            }
        }

        return $thisType;
    }

    public function __toString() {
        if (!empty($this->getMaskedNumber()))
            return (string)$this->getMaskedNumber();

        return 'ID: ' . $this->getId() . ' M:' . $this->getExpirationMonth() . ' Y: ' . $this->getExpirationYear();
    }
}
