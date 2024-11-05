<?php

declare(strict_types=1);

namespace App\Bundles\MainBundle\Entity;

use Common\Utils\LocationUtils;
use Common\Utils\StringUtils;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\VirtualProperty;

class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @Exclude
     */
    public ?int $id;

    /**
     * @Exclude
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected ?\DateTime $updatedAt = null;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected ?\DateTime $createdAt = null;

    /* BLOCK messy hotfix to get funnel flow for VOD vertical to work... */
    public $plainPassword;

    public function __toString()
    {
        return "John Doe";
    }

    /* END BLOCK */

    public function getFirstName()
    {
        return 'John';
    }

    public function getLastName()
    {
        return 'Doe';
    }

    public function getEmail()
    {
        return 'john-doe@email.com';
    }

    public function getPhone()
    {
        return '+52323232232';
    }

    public function getAddress()
    {
        return '123 Main St';
    }


    public function getCity()
    {
        return 'London';
    }

    public function getPostcode()
    {
        return 'XS 1234567';
    }

    public function getState()
    {
        return null;
    }

    public function getAcceptingNewsletter()
    {
        return true;
    }

    public function getCountryCode()
    {
        return 'GB';
    }

    public function getFullName(): string
    {
        return "John Doe";
    }
}
