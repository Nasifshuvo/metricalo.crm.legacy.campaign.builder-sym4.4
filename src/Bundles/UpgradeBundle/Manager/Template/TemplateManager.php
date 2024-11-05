<?php

namespace App\Bundles\UpgradeBundle\Manager\Template;

use App\Bundles\MainBundle\Form\Type\CustomerType;
use App\Bundles\UpgradeBundle\Entity\PageTemplate\PageTemplate;
use App\Bundles\UpgradeBundle\Manager\AbstractManager;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;

class TemplateManager
{
    public const LANDING_PAGE = 'landing';

    public const CHECKOUT_PAGE = 'checkout';

    public const EMAIL = 'email';

    public const REPORT_ABUSE_PAGE = 'report_abuse';

    public const PLEASE_WAIT_PAGE = 'please_wait';

    public const THANK_YOU_PAGE = 'thank_you';

    public const CONFIG_SECTION_TEXT = 'text';

    public const CONFIG_SECTION_THEME = 'theme';

    private Environment $twig;

    public $templateRoot;

    private $landingPageSystem;

    private string $projectDir;

    public function __construct(EntityManagerInterface $em, Environment $twig, $templateRoot, string $projectDirectory)
    {
        $this->twig = $twig;
        $this->templateRoot = $templateRoot;
        $this->projectDir = $projectDirectory;
    }

    public function generateConfig(PageTemplate $pageTemplate)
    {
        $configPath = $this->getBasePath($pageTemplate) . '/config.yml';
        $pagePath = $this->getBasePath($pageTemplate) . '/index.html.twig';

        $pageTextKeys = $this->extractPageTextKeys($pagePath);

        if (!file_exists($configPath)) {
            $this->createEmptyConfig($configPath);
        }

        // existing config
        $configFile = Yaml::parse(file_get_contents($configPath));

        foreach ($configFile['text'] as $key => $configTextValue)
        {
            // unset if not in page, but in config
            if (!in_array($configTextValue, $pageTextKeys)) {
                unset($configFile['text'][$key]);
            }
        }

        foreach ($pageTextKeys as $key => $pageTextKey) {

            // set if in page, but not in config
            if (!in_array($pageTextKey, $configFile['text'])) {
                $configFile['text'][] = $pageTextKey;
            }
        }

        // write config
        $yaml = Yaml::dump($configFile);
        file_put_contents($configPath, $yaml);
    }

    private function extractPageTextKeys($pagePath)
    {
        $this->pageTextKeys = [];
        $this->processedTemplates = [];

        // load base index file
        $htmlContent = file_get_contents($pagePath);

        // extract from base index file
        $this->extractKeysFromHtml($htmlContent);

        // extract from includes, only .html.twig files
        $this->extractAndProcessIncludes($htmlContent);

        return $this->pageTextKeys;
    }

    private function extractAndProcessIncludes($htmlContent)
    {
        $inclPattern = '/\{\%[^%\}]*@([^\s%\}]*\.html\.twig)[^%\}]*\%\}/';

        $queue = [$htmlContent];
        while (!empty($queue)) {
            $currentContent = array_shift($queue); // Get the next item to process

            if (preg_match_all($inclPattern, $currentContent, $matches)) {
                foreach ($matches[1] as $match) {
                    // Skip if this template has already been processed

                    // append the prefix which was removed above
                    $match = '@'.$match;

                    if (in_array($match, $this->processedTemplates)) {
                        continue;
                    }

                    // Mark this template as processed
                    $this->processedTemplates[] = $match;

                    // Load the included template content
                    $loader = $this->twig->getLoader();
                    $sourceContext = $loader->getSourceContext($match);
                    $includedHtmlContent = $sourceContext->getCode();

                    // Add the included content to the queue for further processing
                    $queue[] = $includedHtmlContent;

                    // Here, you might want to process $includedHtmlContent, e.g., extract data
                    $this->extractKeysFromHtml($includedHtmlContent);
                }
            }
        }
    }

    private function extractKeysFromHtml($htmlContent)
    {
        $pattern = '/{{\s*pageText\.get\(\s*[\'"]([\s\S]*?)[\'"]\s*\)\s*(?:\|raw)?\s*}}/';

        preg_match_all($pattern, $htmlContent, $matches);

        $this->pageTextKeys = array_merge($this->pageTextKeys, $matches[1]);
    }

    private function createEmptyConfig($path)
    {
        $array = [
            'text' => [],
            'theme' => [
                'images' => [
                    'dummy' => 'https://place-hold.it/400x200'
                ]
            ]
        ];

        $yaml = Yaml::dump($array);
        file_put_contents($path, $yaml);
    }

    public function getPageTemplatePath(PageTemplate $pageTemplate)
    {
        return $this->getRelativeBasePath($pageTemplate) . '/index.html.twig';
    }

    public function getAdminFields(PageTemplate $pageTemplate, $sectionKey)
    {
        $configArr = $this->getConfig($pageTemplate);

        if (!$configArr || !array_key_exists($sectionKey, $configArr)) {
            return [];
        }

        if ($sectionKey == self::CONFIG_SECTION_TEXT) {

            $pageVars = $pageTemplate->getText();

        } else if ($sectionKey == self::CONFIG_SECTION_THEME) {

            $pageVars = $pageTemplate->getTheme();
        }

        return $pageVars->getAdminFields($configArr[$sectionKey]);
    }

    public function getConfig(PageTemplate $pageTemplate)
    {
        $config = $this->getBasePath($pageTemplate) . '/config.yml';

        if (file_exists($config)) {
            return Yaml::parse(file_get_contents($config));
        } else {
            throw new \Exception('Could not find template config at path: ' . $config);
        }
    }

    public function getFlatConfig(PageTemplate $pageTemplate)
    {
        $config = $this->getBasePath($pageTemplate) . '/config.yml';

        if (!file_exists($config))
            return false;

        return Yaml::parse(file_get_contents($config));
    }

    private function getRelativeBasePath(PageTemplate $pageTemplate): string
    {
        return $this->templateRoot . '/' . $pageTemplate->getTemplateDirName() . '/' . $pageTemplate->getTemplate();
    }

    private function getBasePath(PageTemplate $pageTemplate): string
    {
        return $this->projectDir . '/templates/' . $this->getRelativeBasePath($pageTemplate);
    }

    public function getTemplates(string $pageType): array
    {
        return $this->getTemplateFolders($pageType . '/');
    }

    /** @return mixed[] */
    private function getTemplateFolders(string $folder): array
    {
        $templates = [];

        $finder = new Finder();

        $directories = $finder->directories()->in($this->projectDir . '/templates/' . $this->templateRoot . '/' . $folder);

        foreach ($directories as $directory) {
            if ($directory->getRelativePath() !== '') {
                continue;
            }

            $templates[] = $directory->getRelativePathname();
        }

        return $templates;
    }

    /** @return mixed[] */
    public function getTextPlaceholders(PageTemplate $pageTemplate, $hexKeys = true): array
    {
        $fileConfig = $this->getConfig($pageTemplate);

        if (!is_array($fileConfig) || !array_key_exists('text', $fileConfig)) {
            return [];
        }

        $text = $fileConfig['text'];

        $returnText = [];

        foreach ($text as $elem) {
            if (is_array($elem)) {
                $key = $elem['field']['key'];
                $value = $elem['field']['key'];
            } else {
                $key = $elem;
                $value = $elem;
            }

            if (mb_strpos($value, 'INSTRUCTIONS___') !== false) {
                continue;
            }

            if ($hexKeys) {
                $key = bin2hex($key);
            }

            $returnText[$key] = $value;
        }

        return $returnText;
    }

    public function setLandingPageSystem($system): void
    {
        $this->landingPageSystem = $system;
    }
}
