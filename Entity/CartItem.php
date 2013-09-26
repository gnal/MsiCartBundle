<?php

namespace Msi\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 */
class CartItem
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $quantity;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $price;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    protected $total;

    protected $product;

    /**
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="items")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $cart;

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setQuantity($quantity)
    {
        if ($quantity > 999) {
            $quantity = 999;
        }

        if ($quantity < 1) {
            $quantity = 1;
        }

        $this->quantity = $quantity;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
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

    public function getTotal()
    {
        return $this->total;
    }

    public function setTotal($total)
    {
        $this->total = $total;

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

    public function getCart()
    {
        return $this->cart;
    }

    public function setCart($cart)
    {
        $this->cart = $cart;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }
}
