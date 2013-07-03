<?php

namespace Msi\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Msi\CmfBundle\Doctrine\Extension\Timestampable\TimestampableInterface;
use Msi\CmfBundle\Doctrine\Extension\Translatable\TranslatableInterface;
use Msi\CmfBundle\Doctrine\Extension\Uploadable\UploadableInterface;
use Msi\CmfBundle\Tools\Cutter;

/**
 * @ORM\Entity
 */
class Product implements TimestampableInterface, TranslatableInterface, UploadableInterface
{
    use \Msi\CmfBundle\Doctrine\Extension\Translatable\Traits\TranslatableEntity;
    use \Msi\CmfBundle\Doctrine\Extension\Timestampable\Traits\TimestampableEntity;
    use \Msi\CmfBundle\Doctrine\Extension\Uploadable\Traits\UploadableEntity;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $discountedPrice;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $discountedFrom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $discountedTo;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $published;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $taxable;

    /**
     * @ORM\ManyToOne(targetEntity="ProductCategory")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $category;

    /**
     * @ORM\OneToMany(targetEntity="ProductTranslation", mappedBy="object", cascade={"persist"})
     */
    protected $translations;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $image;

    protected $imageFile;

    public function __construct()
    {
        $this->published = false;
        $this->taxable = true;
        $this->translations = new ArrayCollection();
    }

    public function getRightPrice()
    {
        if ($this->isDiscounted()) {
            return $this->getDiscountedPrice();
        } else {
            return $this->getPrice();
        }
    }

    public function getDiscount()
    {
        if ($this->isDiscounted()) {
            return $this->getDiscountedPrice();
        } else {
            return '';
        }
    }

    public function isDiscounted()
    {
        if (!$this->getDiscountedPrice()) {
            return false;
        }

        if ($this->getDiscountedFrom() && $this->getDiscountedTo()) {
            if (date('Y-m-d') >= $this->getDiscountedFrom()->format('Y-m-d') && date('Y-m-d') <= $this->getDiscountedTo()->format('Y-m-d')) {
                return true;
            }
        }

        if ($this->getDiscountedFrom() && !$this->getDiscountedTo()) {
            if (date('Y-m-d') >= $this->getDiscountedFrom()->format('Y-m-d')) {
                return true;
            }
        }

        if (!$this->getDiscountedFrom() && $this->getDiscountedTo()) {
            if (date('Y-m-d') <= $this->getDiscountedTo()->format('Y-m-d')) {
                return true;
            }
        }

        return false;
    }

    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }

    public function setDiscountedPrice($discountedPrice)
    {
        $this->discountedPrice = $discountedPrice;

        return $this;
    }

    public function getDiscountedFrom()
    {
        return $this->discountedFrom;
    }

    public function setDiscountedFrom($discountedFrom)
    {
        $this->discountedFrom = $discountedFrom;

        return $this;
    }

    public function getDiscountedTo()
    {
        return $this->discountedTo;
    }

    public function setDiscountedTo($discountedTo)
    {
        $this->discountedTo = $discountedTo;

        return $this;
    }

    public function getTaxable()
    {
        return $this->taxable;
    }

    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;
        $this->updateAt = new \DateTime();

        return $this;
    }

    public function getUploadFields()
    {
        return ['image'];
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getPublished()
    {
        return $this->published;
    }

    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    public function getTranslations()
    {
        return $this->translations;
    }

    public function setTranslations($translations)
    {
        $this->translations = $translations;

        return $this;
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
