<?php

namespace Msi\StoreBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;

class CookieListener
{
    protected $cartProvider;

    public function __construct($cartProvider)
    {
        $this->cartProvider = $cartProvider;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $event->getResponse()->headers->setCookie(new Cookie('msci', $this->cartProvider->getCart()->getId()));
    }
}
