<?php

namespace App\Bundles\UpgradeBundle\Manager\Template;

use App\Bundles\UpgradeBundle\Entity\PageTemplate\PageImage;
use App\Bundles\UpgradeBundle\Entity\PageTemplate\PageTemplate;
use App\Bundles\UpgradeBundle\Manager\AbstractManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class DemoPageManager
{

    /**
     * @var ImageManager
     */
    protected $im;

    /**
     * @var TemplateManager
     */
    protected $tm;

    public function __construct(TemplateManager $tm, ImageManager $im)
    {
        $this->tm = $tm;
        $this->im = $im;
    }

    public function createPage(PageTemplate $page, $template)
    {
        $page->setLocale('en')
            ->setTemplate($template);

        $config = $this->tm->getConfig($page);

        if (array_key_exists('text', $config)) {

            $flatArr = [];
            foreach ($config['text'] as $key => $elem) {

                if (is_array($elem)) {
                    $key = $elem['field']['key'];
                    $value = $key;
                } else {
                    $key = $elem;
                    $value = $elem;
                }

                $flatArr[bin2hex($key)] = $value;
            }

            $page->setTextFields($flatArr);
        }

        if (array_key_exists('theme', $config) && array_key_exists('images', $config['theme'])) {
            $page->setThemeFields($config['theme']['images']);
        }

        return $page;
    }
}