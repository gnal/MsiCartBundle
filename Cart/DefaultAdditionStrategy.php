<?php

namespace Msi\StoreBundle\Cart;

use Msi\StoreBundle\Entity\CartItem;
use Msi\StoreBundle\Entity\Cart;

class DefaultAdditionStrategy
{
    public function cartItemTotal(CartItem $item)
    {
        $total = $item->getProduct()->getPrice() * $item->getQuantity();

        return round($total, 2);
    }

    public function cartSubtotal(Cart $cart)
    {
        $total = 0;

        foreach ($cart->getItems() as $item) {
            $total += $this->cartItemTotal($item);
        }

        return round($total, 2);
    }

    public function cartTotal(Cart $cart)
    {
        $subtotal = $this->cartSubtotal($cart);
        $pst      = $this->pstTotal($cart);
        $gst      = $this->gstTotal($cart);

        $total = $subtotal + $gst + $pst;

        return round($total, 2);
    }

    public function getPst()
    {
        return 0.075;
    }

    public function getGst()
    {
        return 0.05;
    }

    public function pstTotal()
    {
        return 1;
    }

    public function gstTotal()
    {
        return 1;
    }

    // private $container;

    // public function __construct(ContainerInterface $container)
    // {
    //     $this->container = $container;
    // }

    // public function getItemTotal(Item $item)
    // {
    //     return $item->getProduct()->getPrice() * $item->getQuantity();
    // }

    // public function getCartSubtotal(Cart $cart)
    // {
    //     $total = 0;
    //     foreach ($cart->getItems() as $item) {
    //         $total += $this->getItemTotal($item);
    //     }

    //     return round($total, 2);
    // }

    // public function getCartGst(Cart $cart)
    // {
    //     $total = 0;
    //     foreach ($cart->getItems() as $item) {
    //         if ($item->getProduct()->getTaxable()) {
    //             $total += $this->getItemTotal($item) * $this->getGst();
    //         }
    //     }

    //     $total += $cart->getShipping()->getPrice() * $this->getGst();

    //     return round($total, 2);
    // }

    // public function getCartPst(Cart $cart)
    // {
    //     $total = 0;
    //     foreach ($cart->getItems() as $item) {
    //         if ($item->getProduct()->getTaxable()) {
    //             $total += $this->getItemTotal($item) * $this->getPst();
    //         }
    //     }

    //     $total += $cart->getShipping()->getPrice() * $this->getPst();

    //     return round($total, 2);
    // }

    // public function getCartTotal(Cart $cart)
    // {
    //     $subtotal = $this->getCartSubtotal($cart);
    //     $pst = $this->getCartPst($cart);
    //     $gst = $this->getCartGst($cart);

    //     $total = $subtotal + $gst + $pst;

    //     return round($total, 2);
    // }
}
