<?php

namespace App\Bundles\UpgradeBundle\Entity\PageTemplate;

use Common\Doctrine\ORM\Traits\Entity;
use Common\Doctrine\ORM\Traits\CreableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class PageWeight
{
    use Entity,
        CreableEntity;

    /**
     * @ORM\ManyToOne(targetEntity="\app_page_template", inversedBy="weights", cascade={"persist"})
     * @ORM\JoinColumn(name="page_id", referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    protected $page;

    /**
     * @ORM\ManyToMany(targetEntity="\app_vertical", mappedBy="checkoutPageWeights", cascade={"persist"})
     */
    protected $verticals;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", options={"default": 0})
     */
    protected $weight = 0;

    /**
     * @return mixed
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param mixed $page
     * @return $this
     */
    public function setPage($page): self
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @return int
     */
    public function getWeight(): int
    {
        return $this->weight;
    }

    /**
     * @param int $weight
     * @return $this
     */
    public function setWeight(int $weight): self
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVerticals()
    {
        return $this->verticals;
    }

    /**
     * @param mixed $verticals
     * @return $this
     */
    public function setVerticals($verticals): self
    {
        $this->verticals = $verticals;
        return $this;
    }
}