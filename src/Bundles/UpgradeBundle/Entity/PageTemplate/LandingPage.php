<?php
namespace App\Bundles\UpgradeBundle\Entity\PageTemplate;

use App\Bundles\UpgradeBundle\Manager\Template\TemplateManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class LandingPage extends PageTemplate implements PageTemplateInterface
{
    protected $campaigns;

    protected $vertical;

    protected $skillGameItem;

    public function __construct()
    {
        parent::__construct();

        $this->campaigns = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getVertical()
    {
        return $this->vertical;
    }

    /**
     * @param mixed $vertical
     * @return $this
     */
    public function setVertical($vertical): self
    {
        $this->vertical = $vertical;
        return $this;
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

    public function getTemplateDirName()
    {
        return TemplateManager::LANDING_PAGE;
    }
}