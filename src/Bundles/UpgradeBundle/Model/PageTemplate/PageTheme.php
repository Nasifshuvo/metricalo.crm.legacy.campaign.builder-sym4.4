<?php

namespace App\Bundles\UpgradeBundle\Model\PageTemplate;

use App\Bundles\UpgradeBundle\Entity\PageTemplate\PageImage;
use App\Bundles\UpgradeBundle\Manager\Template\ImageManager;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PageTheme extends AbstractPageVar
{

    public $images = [];

    /**
     * @param $configArr
     * @return array
     */
    public function getAdminFields($configArr)
    {
        if (!is_array($configArr))
            return [];

        $formFields = [];
        if (array_key_exists('images', $configArr)) {
            $formFields = array_merge($formFields, $this->getImageFormFields($configArr['images']));
        }

        return $formFields;
    }

    public function getImage($key)
    {
        if (!array_key_exists($key, $this->images))
            throw new \Exception('Image with the ID ' . $key . ' was not loaded.');

        return $this->images[$key];
    }

    public function onloadImages(ImageManager $imageManager)
    {
        $configArr = $this->config;

        if (empty($configArr)) {
            return false;
        }

        foreach ($configArr as $key => $item) {

            $this->images[$key] = $item;
        }

        return $this;
    }

    private function getImageFormFields($configArr)
    {
        $formFields = [];

        if (!is_array($configArr)) {
            return $formFields;
        }

        foreach ($configArr as $textField) {

            // lightweight config
            $opts = [
                'class' => PageImage::class,
                'required' => false,
                'choice_label' => 'name',
                'choice_value' => 'id',
            ];

            // If field is array, it's a full config
            if (is_array($textField)) {

                $key = key($textField);
                $fieldType = $textField[$key]['type'];

                if (array_key_exists('options', $textField[$key])) {
                    $opts = array_merge($textField[$key]['options'], $opts);
                }

            } else {

                $key = $textField;
                $fieldType = EntityType::class;
                $opts['label'] = $textField;
            }

            $currentVal = $this->get($key);

            if ($currentVal) {

                if ($this->em) {
                    $entity = $this->em->getRepository(PageImage::class)->find($this->get($key));

                    $opts['data'] = $entity;
                }

            } else {

                $opts['placeholder'] = 'Select Image';
            }
            $formFields[] = [bin2hex($key), $fieldType, $opts];
        }

        return $formFields;
    }
}