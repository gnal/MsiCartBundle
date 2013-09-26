<?php

namespace Msi\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class CartStatus
{
    use \Msi\AdminBundle\Doctrine\Extension\Model\Translatable;
    use \Msi\AdminBundle\Doctrine\Extension\Model\Timestampable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->getTranslation()->getName();
    }
}
