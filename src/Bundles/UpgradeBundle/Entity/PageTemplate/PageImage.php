<?php

namespace App\Bundles\UpgradeBundle\Entity\PageTemplate;

use Common\Doctrine\ORM\Traits\Entity;
use Common\Doctrine\ORM\Traits\NameableEntity;
use App\Bundles\UpgradeBundle\Manager\Template\ImageManager;
use App\Bundles\UpgradeBundle\Manager\Template\TemplateManager;
use Common\Doctrine\ORM\Traits\CreableEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class PageImage
{
    use Entity,
        NameableEntity,
        CreableEntity;

    /**
     * Unmapped property to handle file uploads
     */
    private $file = null;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $filename;

    /**
     * @return null
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param null $file
     * @return $this
     */
    public function setFile($file): self
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getWebPath()
    {
        return '/' . ImageManager::GLOBAL_FOLDER . '/' . $this->getFilename();
    }

    public function __toString()
    {
        return $this->getFilename();
    }
}