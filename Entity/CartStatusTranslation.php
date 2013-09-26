<?php

namespace Msi\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="uniq_object_id_locale", columns={"object_id", "locale"})})
 * @ORM\Entity
 */
class CartStatusTranslation
{
    use \Msi\AdminBundle\Doctrine\Extension\Model\Translation;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}
