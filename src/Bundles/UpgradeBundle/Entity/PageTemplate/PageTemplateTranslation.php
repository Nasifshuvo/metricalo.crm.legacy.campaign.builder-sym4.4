<?php

namespace App\Bundles\UpgradeBundle\Entity\PageTemplate;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslationInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslationTrait;

/**
 * @ORM\Entity
 */
class PageTemplateTranslation implements TranslationInterface
{
    use TranslationTrait;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $customCss;

    /**
     * @var array
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $textFields;

    /**
     * @return mixed
     */
    public function getCustomCss()
    {
        return $this->customCss;
    }

    /**
     * @param mixed $customCss
     * @return $this
     */
    public function setCustomCss($customCss): self
    {
        $this->customCss = $customCss;
        return $this;
    }

    public function getTextFields(): array
    {
        return $this->textFields;
    }

    public function setTextFields(array $textFields): self
    {
        $this->textFields = $textFields;
        return $this;
    }
}