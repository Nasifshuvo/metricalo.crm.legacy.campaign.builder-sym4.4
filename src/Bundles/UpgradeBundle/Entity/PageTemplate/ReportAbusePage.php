<?php
namespace App\Bundles\UpgradeBundle\Entity\PageTemplate;

use App\Bundles\UpgradeBundle\Manager\Template\TemplateManager;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class ReportAbusePage extends PageTemplate implements PageTemplateInterface
{
    public function getTemplateDirName()
    {
        return TemplateManager::REPORT_ABUSE_PAGE;
    }
}