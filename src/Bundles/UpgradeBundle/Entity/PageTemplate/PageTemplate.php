<?php

namespace App\Bundles\UpgradeBundle\Entity\PageTemplate;

use Common\Doctrine\ORM\Traits\NameableEntity;
use App\Bundles\UpgradeBundle\Model\PageTemplate\PageText;
use App\Bundles\UpgradeBundle\Model\PageTemplate\PageTheme;
use Common\Doctrine\ORM\Traits\CommentableEntity;
use Common\Doctrine\ORM\Traits\CreableEntity;
use Common\Doctrine\ORM\Traits\ExternalResourceIdEntity;
use Common\Doctrine\ORM\Traits\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;
use Sonata\TranslationBundle\Model\Gedmo\TranslatableInterface;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 * "landing_page": "LandingPage",
 * "checkout_page": "CheckoutPage",
 * "please_wait_page": "PleaseWaitPage",
 * "thank_you_page": "ThankYouPage",
 * "email": "Email",
 * "report_abuse_page": "ReportAbusePage"
 * })
 */
abstract class PageTemplate implements \Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface, TranslatableInterface
{
    use CommentableEntity;
    use CreableEntity;
    use Entity;
    use ExternalResourceIdEntity;
    use NameableEntity;
    use TranslatableTrait;

    /** No clue how it works without on prod */
    public static function getTranslationEntityClass(): string
    {
        return self::class . 'Translation';
    }

    public function getCurrentLanguage()
    {
        return new Language('en', 'English');
    }

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $template;

    /**
     * @var array
     *
     * @ORM\Column(type="json", nullable=true)
     */
    protected $themeFields;

    /**
     * @ORM\OneToMany(targetEntity="\app_page_weight", mappedBy="page", cascade={"persist"})
     */
    protected $weights;

    /**
     * @ORM\Column(name="default_page", type="boolean", options={"default": false})
     */
    protected $default = true;

    public function __construct()
    {
        $this->weights = new ArrayCollection();
    }

    public function getText($locale = 'en')
    {
        $pageText = new PageText($this->getTextFields($locale));
        $pageText->setPage($this);

        return $pageText;
    }

    public function getTheme()
    {
        $pageTheme = new PageTheme($this->getThemeFields());
        $pageTheme->setPage($this);

        return $pageTheme;
    }

    /** @return mixed */
    public function getCustomCss(?string $locale = 'en')
    {
        /** @var PageTemplateTranslation $translation */
        $translation = $this->translate($locale, false);

        return $translation->getCustomCss();
    }

    public function setCustomCss($textFields, ?string $locale = 'en'): void
    {
        /** @var PageTemplateTranslation $translation */
        $translation = $this->translate($locale, false);

        $translation->setCustomCss($textFields);
    }

    /** @return mixed */
    public function getTextFields(?string $locale = 'en')
    {
        /** @var PageTemplateTranslation $translation */
        $translation = $this->translate($locale, false);

        return $translation->getTextFields();
    }

    public function setTextFields(array $textFields, ?string $locale = 'en'): void
    {
        /** @var PageTemplateTranslation $translation */
        $translation = $this->translate($locale, false);

        $translation->setTextFields($textFields);
    }


    /** @return array */
    public function getThemeFields()
    {
        $themeFields = $this->themeFields;

        if (!is_array($themeFields)) {
            return [];
        }

        return $themeFields;
    }

    /** @return $this */
    public function setThemeFields(array $themeFields): self
    {
        $this->themeFields = $themeFields;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate()
    {
        return $this->template;
    }

    /**
     * @param string $template
     * @return $this
     */
    public function setTemplate(string $template): self
    {
        $this->template = $template;
        return $this;
    }

    public function getWeights()
    {
        return $this->weights;
    }

    /**
     * @return $this
     */
    public function setWeights($weights): self
    {
        $this->weights = $weights;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocale()
    {
        return $this->getCurrentLocale();
    }

    /**
     * @param string $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->setCurrentLocale($locale);
        return $this;
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->default;
    }

    /**
     * @param bool $default
     * @return $this
     */
    public function setDefault(bool $default): self
    {
        $this->default = $default;
        return $this;
    }

    public function __clone()
    {
        $this->id = null;
    }

    public function __toString()
    {
        return $this->getName();
    }
}