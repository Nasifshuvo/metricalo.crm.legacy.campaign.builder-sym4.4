<?php

namespace App\Bundles\UpgradeBundle\Manager\Template;

use App\Bundles\UpgradeBundle\Entity\PageTemplate\PageImage;
use App\Bundles\UpgradeBundle\Entity\PageTemplate\PageTemplate;
use App\Bundles\UpgradeBundle\Manager\AbstractManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageManager
{
    const GLOBAL_FOLDER = '_images';

    /**
     * @var TemplateManager
     */
    public $tm;

    /**
     * @var string
     */
    protected $kernelRootDir;

    public function __construct($kernelRootDir, TemplateManager $tm)
    {
        $this->kernelRootDir = $kernelRootDir;
        $this->tm = $tm;
    }

    public function upload(PageImage $pageImage)
    {
        $file = $pageImage->getFile();

        if (!$file instanceof UploadedFile)
            return false;

        // Delete current if exists, before upload
        if ($file->getFilename())
            unlink($this->getFilesystemFullPath($pageImage));

        $newFilename = rand(1,99999999999999) . '.' . $file->getClientOriginalExtension();

        $file->move(
            $this->getTemplateFolderPath(),
            $newFilename
        );

        // set the path property to the filename where you've saved the file
        $pageImage->setFilename($newFilename);

        // clean up the file property as you won't need it anymore
        $pageImage->setFile(null);
    }

    public function serveImageWebPathById($id)
    {
        $pageImage = $this->getRepo(PageImage::class)->find($id);

        if (!$pageImage)
            return false;

        return $this->getWebResourceUrl($pageImage);
    }

    public function serveImageWebPath($filename)
    {
        $pageImage = $this->getRepo(PageImage::class)->findOneBy(['filename' => $filename]);

        if (!$pageImage)
            return false;

        return $this->getWebResourceUrl($pageImage);
    }

    private function getWebResourceUrl(PageImage $pageImage)
    {
        $path = $this->getWebFolderFilePath($pageImage);

        $fs = new Filesystem();

        if (!$fs->exists($path)) {

            // Copy from EFS
            $fs->copy($this->getFilesystemFullPath($pageImage), $path);
        }

        return '/' . self::GLOBAL_FOLDER . '/' . $pageImage->getFilename();
    }

    public function getWebFolderFilePath(PageImage $pageImage)
    {
        return $this->kernelRootDir . '/../web/' . self::GLOBAL_FOLDER . '/' . $pageImage->getFilename();
    }

    public function getTemplateFolderPath()
    {
        return $this->tm->templateRoot . '/' . self::GLOBAL_FOLDER;
    }

    public function getFilesystemFullPath(PageImage $pageImage)
    {
        return $this->getTemplateFolderPath() . '/' . $pageImage->getFilename();
    }
}