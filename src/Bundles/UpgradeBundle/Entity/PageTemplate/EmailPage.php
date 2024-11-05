<?php
namespace App\Bundles\UpgradeBundle\Entity\PageTemplate;

use App\Bundles\UpgradeBundle\Manager\Template\TemplateManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class EmailPage extends PageTemplate implements PageTemplateInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTemplateDirName()
    {
        return TemplateManager::EMAIL;
    }
}