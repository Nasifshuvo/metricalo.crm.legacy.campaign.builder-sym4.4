<?php
namespace App\Bundles\UpgradeBundle\Entity\PageTemplate;

use App\Bundles\UpgradeBundle\Manager\Template\TemplateManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class CheckoutPage extends PageTemplate implements PageTemplateInterface
{
    /**
     * @ORM\OneToMany(targetEntity="\app_customer", mappedBy="checkoutPage")
     */
    protected $customers;

    public function __construct()
    {
        parent::__construct();

        $this->customers = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * @param mixed $customers
     * @return $this
     */
    public function setCustomers($customers): self
    {
        $this->customers = $customers;
        return $this;
    }

    public function getTemplateDirName()
    {
        return TemplateManager::CHECKOUT_PAGE;
    }
}