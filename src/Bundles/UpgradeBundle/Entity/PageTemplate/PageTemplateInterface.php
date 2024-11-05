<?php

namespace App\Bundles\UpgradeBundle\Entity\PageTemplate;

interface PageTemplateInterface {

    public function getTextFields();

    public function getThemeFields();

    public function getTemplate();

    public function getTemplateDirName();
}