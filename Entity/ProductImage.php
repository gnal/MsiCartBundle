<?php

namespace Msi\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Msi\AdminBundle\Tools\Cutter;

/**
 * @ORM\Entity
 */
class ProductImage
{
    use \Msi\AdminBundle\Doctrine\Extension\Model\Timestampable;
    use \Msi\AdminBundle\Doctrine\Extension\Model\Uploadable;
    use \Msi\AdminBundle\Doctrine\Extension\Model\Sortable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $filename;

    protected $filenameFile;

    protected $product;

    public function processFilename($file)
    {
        $cutter = new Cutter($file);
        $cutter->resizeProp(600)->save('600');
        $cutter->resizeProp(300)->save('300');
        $cutter->resize(64, 64)->save('64x64');
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    public function getFilenameFile()
    {
        return $this->filenameFile;
    }

    public function setFilenameFile($filenameFile)
    {
        $this->filenameFile = $filenameFile;
        $this->updateAt = new \DateTime();

        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    // public function getUploadDirSuffix()
    // {
    //     return $this->getProduct()->getId();
    // }

    public function getUploadFields()
    {
        return ['filename'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}
