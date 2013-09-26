<?php

namespace Msi\StoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;

class CookieListener
{
    protected $cart;

    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $event->getResponse()->headers->setCookie(new Cookie('msci', $this->cart->getId()));
    }
}
