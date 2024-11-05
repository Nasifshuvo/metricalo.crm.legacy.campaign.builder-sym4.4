<?php

namespace App\Bundles\UpgradeBundle\Model\PageTemplate;

use App\Bundles\UpgradeBundle\Entity\PageTemplate\PageTemplate;

abstract class AbstractPageVar
{

    /**
     * Might be set in some context such as admin rendering
     */
    public $em;

    /**
     * @var PageTemplate
     */
    protected $page;

    protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function get($key)
    {
        if (!is_array($this->config))
            return $key;

        $hexKey = bin2hex($key);

        if (array_key_exists($hexKey, $this->config))
            return $this->config[$hexKey];

        return $key;
    }

    /**
     * @return PageTemplate
     */
    public function getPage(): PageTemplate
    {
        return $this->page;
    }

    /**
     * @param PageTemplate $page
     * @return $this
     */
    public function setPage(PageTemplate $page): self
    {
        $this->page = $page;
        return $this;
    }


    /**
     * @param $configArr
     * @return array
     */
    public function getAdminFields($configArr)
    {
        throw new \Exception('You must override admin field parsing in the child class of ' . self::class);
    }
}