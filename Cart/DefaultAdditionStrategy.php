<?php

namespace Msi\StoreBundle\Cart;

use Msi\StoreBundle\Entity\CartItem;
use Msi\StoreBundle\Entity\Cart;

class DefaultAdditionStrategy
{
    public function cartItemTotal(CartItem $item)
    {
        if ($item->getProduct()->isDiscounted()) {
            $price = $item->getProduct()->getDiscountedPrice();
        } else {
            $price = $item->getProduct()->getPrice();
        }

        return round($price * $item->getQuantity(), 2);
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

    public function pst()
    {
        return 0.075;
    }

    public function gst()
    {
        return 0.05;
    }

    public function gstTotal(Cart $cart)
    {
        $total = 0;

        foreach ($cart->getItems() as $item) {
            if ($item->getProduct()->getTaxable()) {
                $total += $this->cartItemTotal($item) * $this->gst();
            }
        }

        // $total += $cart->getShipping()->getPrice() * $this->gst();

        return round($total, 2);
    }

    public function pstTotal(Cart $cart)
    {
        $total = 0;

        foreach ($cart->getItems() as $item) {
            if ($item->getProduct()->getTaxable()) {
                $total += $this->cartItemTotal($item) * $this->pst();
            }
        }

        // $total += $cart->getShipping()->getPrice() * $this->pst();

        return round($total, 2);
    }
}
