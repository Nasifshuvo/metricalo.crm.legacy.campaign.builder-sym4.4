<?php


namespace App\Bundles\AffiliateBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table()
 * @ORM\Entity()
 */
class ClickAbuseCase
{
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $caseId;

    /**
     * @ORM\ManyToOne(targetEntity="\app_lead", inversedBy="", cascade={"persist"})
     * @ORM\JoinColumn(name="lead_id", referencedColumnName="id", nullable=true)
     */
    protected $lead;

    /**
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCaseId()
    {
        return $this->caseId;
    }

    /**
     * @param mixed $caseId
     * @return $this
     */
    public function setCaseId($caseId): self
    {
        $this->caseId = $caseId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param mixed $lead
     * @return $this
     */
    public function setLead($lead): self
    {
        $this->lead = $lead;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     * @return $this
     */
    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return $this
     */
    public function setDescription($description): self
    {
        $this->description = $description;
        return $this;
    }
}